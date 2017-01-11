const Lightbox = (($) => {

	const NAME = 'ekkoLightbox'
	const JQUERY_NO_CONFLICT = $.fn[NAME]

	const Default = {
		title: '',
		footer: '',
		showArrows: true, //display the left / right arrows or not
		type: null, //force the lightbox into image / youtube mode. if null, or not image|youtube|vimeo; detect it
		alwaysShowClose: false, //always show the close button, even if there is no title
		loadingMessage: '<div class="ekko-lightbox-loader"><div><div></div><div></div></div></div>', // http://tobiasahlin.com/spinkit/
		leftArrow: '<span>&#10094;</span>',
		rightArrow: '<span>&#10095;</span>',
		strings: {
			close: 'Close',
			fail: 'Failed to load image:',
			type: 'Could not detect remote target type. Force the type using data-type',
		},
		doc: document, // if in an iframe can specify top.document
		onShow() {},
		onShown() {},
		onHide() {},
		onHidden() {},
		onNavigate() {},
		onContentLoaded() {}
	}

	class Lightbox {

		/**
		 
	    Class properties:
		 
		 _$element: null -> the <a> element currently being displayed
		 _$modal: The bootstrap modal generated
		    _$modalDialog: The .modal-dialog
		    _$modalContent: The .modal-content
		    _$modalBody: The .modal-body
		    _$modalHeader: The .modal-header
		    _$modalFooter: The .modal-footer
		 _$lightboxContainerOne: Container of the first lightbox element
		 _$lightboxContainerTwo: Container of the second lightbox element
		 _$lightboxBody: First element in the container
		 _$modalArrows: The overlayed arrows container

		 _$galleryItems: Other <a>'s available for this gallery
		 _galleryName: Name of the current data('gallery') showing
		 _galleryIndex: The current index of the _$galleryItems being shown

		 _config: {} the options for the modal
		 _modalId: unique id for the current lightbox
		 _padding / _border: CSS properties for the modal container; these are used to calculate the available space for the content

		 */

		static get Default() {
			return Default
		}

		constructor($element, config) {
			this._config = $.extend({}, Default, config)
			this._$modalArrows = null
			this._galleryIndex = 0
			this._galleryName = null
			this._padding = null
			this._border = null
			this._titleIsShown = false
			this._footerIsShown = false
			this._wantedWidth = 0
			this._wantedHeight = 0
			this._modalId = `ekkoLightbox-${Math.floor((Math.random() * 1000) + 1)}`;
			this._$element = $element instanceof jQuery ? $element : $($element)

			let header = `<div class="modal-header"${this._config.title || this._config.alwaysShowClose ? '' : ' style="display:none"'}><button type="button" class="close" data-dismiss="modal" aria-label="${this._config.strings.close}"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">${this._config.title || "&nbsp;"}</h4></div>`;
			let footer = `<div class="modal-footer"${this._config.footer ? '' : ' style="display:none"'}>${this._config.footer || "&nbsp;"}</div>`;
			let body = '<div class="modal-body"><div class="ekko-lightbox-container"><div class="ekko-lightbox-item fade in"></div><div class="ekko-lightbox-item fade"></div></div></div>'
			let dialog = `<div class="modal-dialog" role="document"><div class="modal-content">${header}${body}${footer}</div></div>`
			$(this._config.doc.body).append(`<div id="${this._modalId}" class="ekko-lightbox modal fade" tabindex="-1" tabindex="-1" role="dialog" aria-hidden="true">${dialog}</div>`)

			this._$modal = $(`#${this._modalId}`, this._config.doc)
			this._$modalDialog = this._$modal.find('.modal-dialog').first()
			this._$modalContent = this._$modal.find('.modal-content').first()
			this._$modalBody = this._$modal.find('.modal-body').first()
			this._$modalHeader = this._$modal.find('.modal-header').first()
			this._$modalFooter = this._$modal.find('.modal-footer').first()

			this._$lightboxContainer = this._$modalBody.find('.ekko-lightbox-container').first()
			this._$lightboxBodyOne = this._$lightboxContainer.find('> div:first-child').first()
			this._$lightboxBodyTwo = this._$lightboxContainer.find('> div:last-child').first()

			this._border = this._calculateBorders()
			this._padding = this._calculatePadding()

			this._galleryName = this._$element.data('gallery')
			if (this._galleryName) {
				this._$galleryItems = $(document.body).find(`*[data-gallery="${this._galleryName}"]`)
				this._galleryIndex = this._$galleryItems.index(this._$element)
				$(document).on('keydown.ekkoLightbox', this._navigationalBinder.bind(this))

				// add the directional arrows to the modal
				if (this._config.showArrows && this._$galleryItems.length > 1) {
					this._$lightboxContainer.append(`<div class="ekko-lightbox-nav-overlay"><a href="#">${this._config.leftArrow}</a><a href="#">${this._config.rightArrow}</a></div>`)
					this._$modalArrows = this._$lightboxContainer.find('div.ekko-lightbox-nav-overlay').first()
					this._$lightboxContainer.on('click', 'a:first-child', event => {
						event.preventDefault()
						return this.navigateLeft()
					})
					this._$lightboxContainer.on('click', 'a:last-child', event => {
						event.preventDefault()
						return this.navigateRight()
					})
				}
			}

			this._$modal
			.on('show.bs.modal', this._config.onShow.bind(this))
			.on('shown.bs.modal', () => {
				this._toggleLoading(true)
				this._handle()
				return this._config.onShown.call(this)
			})
			.on('hide.bs.modal', this._config.onHide.bind(this))
			.on('hidden.bs.modal', () => {
				if (this._galleryName) {
					$(document).off('keydown.ekkoLightbox')
					$(window).off('resize.ekkoLightbox')
				}
				this._$modal.remove()
				return this._config.onHidden.call(this)
			})
			.modal(this._config)

			$(window).on('resize.ekkoLightbox', () => {
				this._resize(this._wantedWidth, this._wantedHeight)
			})
		}

		element() {
			return this._$element;
		}

		modal() {
			return this._$modal;
		}

		navigateTo(index) {

			if (index < 0 || index > this._$galleryItems.length-1)
				return this

			this._galleryIndex = index

			this._$element = $(this._$galleryItems.get(this._galleryIndex))
			this._handle();
		}

		navigateLeft() {

			if (this._$galleryItems.length === 1)
				return

			if (this._galleryIndex === 0)
				this._galleryIndex = this._$galleryItems.length - 1
			else //circular
				this._galleryIndex--

			this._config.onNavigate.call(this, 'left', this._galleryIndex)
			return this.navigateTo(this._galleryIndex)
		}

		navigateRight() {

			if (this._$galleryItems.length === 1)
				return

			if (this._galleryIndex === this._$galleryItems.length - 1)
				this._galleryIndex = 0
			else //circular
				this._galleryIndex++

			this._config.onNavigate.call(this, 'right', this._galleryIndex)
			return this.navigateTo(this._galleryIndex)
		}

		close() {
			return this._$modal.modal('hide');
		}

		// helper private methods
		_navigationalBinder(event) {
			event = event || window.event;
			if (event.keyCode === 39)
				return this.navigateRight()
			if (event.keyCode === 37)
				return this.navigateLeft()
		}

		// type detection private methods
		_detectRemoteType(src, type) {

			type = type || false;

			if(!type && this._isImage(src))
				type = 'image';
			if(!type && this._getYoutubeId(src))
				type = 'youtube';
			if(!type && this._getVimeoId(src))
				type = 'vimeo';
			if(!type && this._getInstagramId(src))
				type = 'instagram';

			if(!type || ['image', 'youtube', 'vimeo', 'instagram', 'video', 'url'].indexOf(type) < 0)
				type = 'url';

			return type;
		}

		_isImage(string) {
			return string && string.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
		}

		_containerToUse() {
			// if currently showing an image, fade it out and remove
			let $toUse = this._$lightboxBodyTwo
			let $current = this._$lightboxBodyOne

			if(this._$lightboxBodyTwo.hasClass('in')) {
				$toUse = this._$lightboxBodyOne
				$current = this._$lightboxBodyTwo
			}

			$current.removeClass('in')
			setTimeout(() => {
				if(!this._$lightboxBodyTwo.hasClass('in'))
					this._$lightboxBodyTwo.empty()
				if(!this._$lightboxBodyOne.hasClass('in'))
					this._$lightboxBodyOne.empty()
			}, 500)

			$toUse.addClass('in')
			return $toUse
		}

		_handle() {

			let $toUse = this._containerToUse()
			this._updateTitleAndFooter()

			let currentRemote = this._$element.attr('data-remote') || this._$element.attr('href')
			let currentType = this._detectRemoteType(currentRemote, this._$element.attr('data-type') || false)

			if(['image', 'youtube', 'vimeo', 'instagram', 'video', 'url'].indexOf(currentType) < 0)
				return this._error(this._config.strings.type)

			switch(currentType) {
				case 'image':
					this._preloadImage(currentRemote, $toUse)
					this._preloadImageByIndex(this._galleryIndex, 3)
					break;
				case 'youtube':
					this._showYoutubeVideo(currentRemote, $toUse);
					break;
				case 'vimeo':
					this._showVimeoVideo(this._getVimeoId(currentRemote), $toUse);
					break;
				case 'instagram':
					this._showInstagramVideo(this._getInstagramId(currentRemote), $toUse);
					break;
				case 'video':
					this._showHtml5Video(currentRemote, $toUse);
					break;
				default: // url
					this._loadRemoteContent(currentRemote, $toUse);
					break;
			}

			return this;
		}

		_getYoutubeId(string) {
			if(!string)
				return false;
			let matches = string.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/)
			return (matches && matches[2].length === 11) ? matches[2] : false
		}

		_getVimeoId(string) {
			return string && string.indexOf('vimeo') > 0 ? string : false
		}

		_getInstagramId(string) {
			return string && string.indexOf('instagram') > 0 ? string : false
		}

		// layout private methods
		_toggleLoading(show) {
			show = show || false
			if(show) {
				this._$modalDialog.css('display', 'none')
				this._$modal.removeClass('in')
				$('.modal-backdrop').append(this._config.loadingMessage)
			}
			else {
				this._$modalDialog.css('display', 'block')
				this._$modal.addClass('in')
				$('.modal-backdrop').find('.ekko-lightbox-loader').remove()
			}
			return this;
		}

		_calculateBorders() {
			return {
				top: this._totalCssByAttribute('border-top-width'),
				right: this._totalCssByAttribute('border-right-width'),
				bottom: this._totalCssByAttribute('border-bottom-width'),
				left: this._totalCssByAttribute('border-left-width'),
			}
		}
		
		_calculatePadding() {
			return {
				top: this._totalCssByAttribute('padding-top'),
				right: this._totalCssByAttribute('padding-right'),
				bottom: this._totalCssByAttribute('padding-bottom'),
				left: this._totalCssByAttribute('padding-left'),
			}
		}

		_totalCssByAttribute(attribute) {
			return parseInt(this._$modalDialog.css(attribute), 10) +
				parseInt(this._$modalContent.css(attribute), 10) +
				parseInt(this._$modalBody.css(attribute), 10)
		}

		_updateTitleAndFooter() {
			let title = this._$element.data('title') || ""
			let caption = this._$element.data('footer') || ""

			this._titleIsShown = false
			if (title || this._config.alwaysShowClose) {
				this._titleIsShown = true
				this._$modalHeader.css('display', '').find('.modal-title').html(title || "&nbsp;")
			}
			else
				this._$modalHeader.css('display', 'none')

			this._footerIsShown = false
			if (caption) {
				this._footerIsShown = true
				this._$modalFooter.css('display', '').html(caption)
			}
			else
				this._$modalFooter.css('display', 'none')

			return this;
		}

		_showYoutubeVideo(remote, $containerForElement) {
			let id = this._getYoutubeId(remote)
			let query = remote.indexOf('&') > 0 ? remote.substr(remote.indexOf('&')) : ''
			let width = this._$element.data('width') || 560
			let height = this._$element.data('height') ||  width / ( 560/315 )
			return this._showVideoIframe(
				`//www.youtube.com/embed/${id}?badge=0&autoplay=1&html5=1${query}`,
				width,
				height,
				$containerForElement
			);
		}

		_showVimeoVideo(id, $containerForElement) {
			let width = 500
			let height = this._$element.data('height') ||  width / ( 560/315 )
			return this._showVideoIframe(id + '?autoplay=1', width, height, $containerForElement)
		}

		_showInstagramVideo(id, $containerForElement) {
			// instagram load their content into iframe's so this can be put straight into the element
			let width = this._$element.data('width') || 612
			let height = width + 80;
			id = id.substr(-1) !== '/' ? id + '/' : id; // ensure id has trailing slash
			$containerForElement.html(`<iframe width="${width}" height="${height}" src="${id}embed/" frameborder="0" allowfullscreen></iframe>`);
			this._resize(width, height);
			this._config.onContentLoaded.call(this);
			if (this._$modalArrows) //hide the arrows when showing video
				this._$modalArrows.css('display', 'none');
			this._toggleLoading(false);
			return this;
		}

		_showVideoIframe(url, width, height, $containerForElement) { // should be used for videos only. for remote content use loadRemoteContent (data-type=url)
			height = height || width; // default to square
			$containerForElement.html(`<div class="embed-responsive embed-responsive-16by9"><iframe width="${width}" height="${height}" src="${url}" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe></div>`);
			this._resize(width, height);
			this._config.onContentLoaded.call(this);
			if (this._$modalArrows)
				this._$modalArrows.css('display', 'none'); //hide the arrows when showing video
			this._toggleLoading(false);
			return this;
		}

		_showHtml5Video(url, $containerForElement) { // should be used for videos only. for remote content use loadRemoteContent (data-type=url)
			let width = this._$element.data('width') || 560
			let height = this._$element.data('height') ||  width / ( 560/315 )
			$containerForElement.html(`<div class="embed-responsive embed-responsive-16by9"><video width="${width}" height="${height}" src="${url}" preload="auto" autoplay controls class="embed-responsive-item"></video></div>`);
			this._resize(width, height);
			this._config.onContentLoaded.call(this);
			if (this._$modalArrows)
				this._$modalArrows.css('display', 'none'); //hide the arrows when showing video
			this._toggleLoading(false);
			return this;
		}

		_loadRemoteContent(url, $containerForElement) {
			let width = this._$element.data('width') || 560;
			let height = this._$element.data('height') || 560;

			let disableExternalCheck = this._$element.data('disableExternalCheck') || false;
			this._toggleLoading(false);

			// external urls are loading into an iframe
			// local ajax can be loaded into the container itself
			if (!disableExternalCheck && !this._isExternal(url)) {
				$containerForElement.load(url, $.proxy(() => {
					return this._$element.trigger('loaded.bs.modal');l
				}));

			} else {
				$containerForElement.html(`<iframe src="${url}" frameborder="0" allowfullscreen></iframe>`);
				this._config.onContentLoaded.call(this);
			}

			if (this._$modalArrows) //hide the arrows when remote content
				this._$modalArrows.css('display', 'none')

			this._resize(width, height);
			return this;
		}

		_isExternal(url) {
			let match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
			if (typeof match[1] === "string" && match[1].length > 0 && match[1].toLowerCase() !== location.protocol)
				return true;

			if (typeof match[2] === "string" && match[2].length > 0 && match[2].replace(new RegExp(`:(${{
					"http:": 80,
					"https:": 443
				}[location.protocol]})?$`), "") !== location.host)
				return true;

			return false;
		}

		_error( message ) {
			console.error(message);
			this._containerToUse().html(message);
			this._resize(300, 300);
			return this;
		}

		_preloadImageByIndex(startIndex, numberOfTimes) {

			if(!this._$galleryItems)
				return;

			let next = $(this._$galleryItems.get(startIndex), false)
			if(typeof next == 'undefined')
				return

			let src = next.attr('data-remote') || next.attr('href')
			if (next.attr('data-type') === 'image' || this._isImage(src))
				this._preloadImage(src, false)

			if(numberOfTimes > 0)
				return this._preloadImageByIndex(startIndex + 1, numberOfTimes-1);
		}

		_preloadImage( src, $containerForImage) {

			$containerForImage = $containerForImage || false

			let img = new Image();
			if ($containerForImage) {

				// if loading takes > 200ms show a loader
				let loadingTimeout = setTimeout(() => {
					$containerForImage.append(this._config.loadingMessage)
				}, 200)

				img.onload = () => {
					if(loadingTimeout)
						clearTimeout(loadingTimeout)
					loadingTimeout = null;
					let image = $('<img />');
					image.attr('src', img.src);
					image.addClass('img-fluid');
					$containerForImage.html(image);
					if (this._$modalArrows)
						this._$modalArrows.css('display', '') // remove display to default to css property

					this._resize(img.width, img.height);
					this._toggleLoading(false);
					return this._config.onContentLoaded.call(this);
				};
				img.onerror = () => {
					this._toggleLoading(false);
					return this._error(this._config.strings.fail+`  ${src}`);
				};
			}

			img.src = src;
			return img;
		}

		_resize( width, height ) {

			height = height || width
			this._wantedWidth = width
			this._wantedHeight = height

			// if width > the available space, scale down the expected width and height
			let widthBorderAndPadding = this._padding.left + this._padding.right + this._border.left + this._border.right
			let maxWidth = Math.min(width + widthBorderAndPadding, this._config.doc.body.clientWidth)
			if((width + widthBorderAndPadding) > maxWidth) {
				height = ((maxWidth - widthBorderAndPadding) /  width) * height
				width = maxWidth
			} else
				width = (width + widthBorderAndPadding)

			let headerHeight = 0,
				footerHeight = 0

			// as the resize is performed the modal is show, the calculate might fail
			// if so, default to the default sizes
			if (this._footerIsShown)
				footerHeight = this._$modalFooter.outerHeight(true) || 55

			if (this._titleIsShown)
				headerHeight = this._$modalHeader.outerHeight(true) || 67

			let borderPadding = this._padding.top + this._padding.bottom + this._border.bottom + this._border.top

			//calculated each time as resizing the window can cause them to change due to Bootstraps fluid margins
			let margins = parseFloat(this._$modalDialog.css('margin-top')) + parseFloat(this._$modalDialog.css('margin-bottom'));

			let maxHeight = Math.min(height, $(window).height() - borderPadding - margins - headerHeight - footerHeight);
			if(height > maxHeight) {
				// if height > the available height, scale down the width
				let factor = Math.min(maxHeight / height, 1);
				width = Math.ceil(factor * width);
			}

			this._$lightboxContainer.css('height', maxHeight)
			this._$modalDialog.css('width', 'auto') .css('maxWidth', width);

			this._$modal.modal('_handleUpdate');
			return this;
		}

		static _jQueryInterface(config) {
			config = config || {}
			return this.each(() => {
				let $this = $(this)
				let _config = $.extend(
					{},
					Lightbox.Default,
					$this.data(),
					typeof config === 'object' && config
				)

				new Lightbox(this, _config)
			})
		}
	}



	$.fn[NAME]             = Lightbox._jQueryInterface
	$.fn[NAME].Constructor = Lightbox
	$.fn[NAME].noConflict  = () => {
		$.fn[NAME] = JQUERY_NO_CONFLICT
		return Lightbox._jQueryInterface
	}

	return Lightbox

})(jQuery)

export default Lightbox