/**
 * jsPDF AutoTable plugin
 * Copyright (c) 2014 Simon Bengtsson, https://github.com/someatoms/jsPDF-AutoTable
 *
 * Licensed under the MIT License.
 * http://opensource.org/licenses/mit-license
 */
(function (API) {
    'use strict';

    // On every new jsPDF object, clear variables
    API.events.push(['initialized', function () {
        doc = undefined;
        cellPos = undefined;
        pageCount = 1;
        settings = undefined;
    }], false);

    var MIN_COLUMN_WIDTH = 25;

    var doc, cellPos, pageCount = 1, settings;

    // See README.md or examples for documentation of the options
    // return a new instance every time to avoid references issues
    var defaultOptions = function () {
        return {
            padding: 5,
            fontSize: 10,
            lineHeight: 20,
            renderHeader: function (doc, pageNumber, settings) {
            },
            renderFooter: function (doc, lastCellPos, pageNumber, settings) {
            },
            renderHeaderCell: function (x, y, width, height, key, value, settings) {
                doc.setFillColor(52, 73, 94); // Asphalt
                doc.setTextColor(255, 255, 255);
                doc.setFontStyle('bold');
                doc.rect(x, y, width, height, 'F');
                y += settings.lineHeight / 2 + API.autoTableTextHeight() / 2;
                doc.text(value, x + settings.padding, y);
            },
            renderCell: function (x, y, width, height, key, value, row, settings) {
                doc.setFillColor(row % 2 === 0 ? 245 : 255);
                doc.setTextColor(50);
                doc.rect(x, y, width, height, 'F');
                y += settings.lineHeight / 2 + API.autoTableTextHeight() / 2 - 2.5;
                doc.text(value, x + settings.padding, y);
            },
            margins: {right: 40, left: 40, top: 50, bottom: 40},
            startY: false,
            overflow: 'ellipsize', // false, ellipsize or linebreak (false passes the raw text to renderCell)
            overflowColumns: false, // Specify which colums that gets subjected to the overflow method chosen. false indicates all
            avoidPageSplit: false,
            extendWidth: true
        }
    };

    /**
     * Create a table from a set of rows and columns.
     *
     * @param {Object[]|String[]} columns Either as an array of objects or array of strings
     * @param {Object[][]|String[][]} data Either as an array of objects or array of strings
     * @param {Object} [options={}] Options that will override the default ones (above)
     */
    API.autoTable = function (columns, data, options) {
        options = options || {};
        columns = columns || [];
        doc = this;

        var userFontSize = doc.internal.getFontSize();

        initData({columns: columns, data: data});
        initOptions(options);

        cellPos = {
            x: settings.margins.left,
            y: settings.startY === false ? settings.margins.top : settings.startY
        };

        var tableHeight = settings.margins.bottom + settings.margins.top + settings.lineHeight * (data.length + 1) + 5 + settings.startY;
        if (settings.startY !== false && settings.avoidPageSplit && tableHeight > doc.internal.pageSize.height) {
            pageCount++;
            doc.addPage();
            cellPos.y = settings.margins.top;
        }

        settings.renderHeader(doc, pageCount, settings);
        var columnWidths = calculateColumnWidths(data, columns);
        printHeader(columns, columnWidths);
        printRows(columns, data, columnWidths);
        settings.renderFooter(doc, cellPos, pageCount, settings);

        doc.setFontSize(userFontSize);

        return this;
    };

    /**
     * Returns the Y position of the last drawn cell
     * @returns int
     */
    API.autoTableEndPosY = function () {
        // If cellPos is not set, autoTable() has probably not been called
        return cellPos ? cellPos.y : false;
    };

    /**
     * @deprecated Use autoTableEndPosY()
     */
    API.autoTableEndPos = function () {
        return cellPos;
    };

    /**
     * Parses an html table. To draw a table, use it like this:
     * `doc.autoTable(false, doc.autoTableHtmlToJson(tableDomElem))`
     *
     * @param table Html table element
     * @param indexBased Boolean flag if result should be returned as seperate cols and data
     * @returns []|{} Array of objects with object keys as headers or based on indexes if indexBased is set to true
     */
    API.autoTableHtmlToJson = function (table, indexBased) {
            var data = [], headers = {}, header = table.rows[0], i, tableRow, rowData, j;
        if (indexBased) {
            headers = [];
            for (i = 0; i < header.cells.length; i++) {
                headers.push(header.cells[i] ? header.cells[i].textContent : '');
            }

            for (i = 1; i < table.rows.length; i++) {
                tableRow = table.rows[i];
                rowData = [];
                for (j = 0; j < header.cells.length; j++) {
                    rowData.push(tableRow.cells[j] ? tableRow.cells[j].textContent : '');
                }
                data.push(rowData);
            }
            return {columns: headers, data: data};
        } else {
            for (i = 0; i < header.cells.length; i++) {
                headers[i] = header.cells[i] ? header.cells[i].textContent : '';
            }

            for (i = 1; i < table.rows.length; i++) {
                tableRow = table.rows[i];
                rowData = {};
                for (j = 0; j < header.cells.length; j++) {
                    rowData[headers[j]] = tableRow.cells[j] ? tableRow.cells[j].textContent : '';
                }
                data.push(rowData);
            }

            return data;
        }
    };

    /**
     * Basically the same as getLineHeight() in 1.0+ versions of jsPDF, however
     * added here for backwards compatibility with version 0.9
     *
     * Export it to make it available in drawCell and drawHeaderCell
     */
    API.autoTableTextHeight = function() {
        // The value 1.15 comes from from the jsPDF source code and looks about right
        return doc.internal.getFontSize() * 1.15;
    };

    /**
     * Transform all to the object initialization form
     * @param params
     */
    function initData(params) {

        // Object only initial
        if (!params.columns || params.columns.length === 0) {
            var keys = Object.keys(params.data[0]);
            Array.prototype.push.apply(params.columns, keys);
            params.columns.forEach(function (title, i) {
                params.columns[i] = {title: title, key: keys[i]};
            });
        }
        // Array initialization form
        else if (typeof params.columns[0] === 'string') {
            params.data.forEach(function (row, i) {
                var obj = {};
                for (var j = 0; j < row.length; j++) {
                    obj[j] = params.data[i][j];
                }
                params.data[i] = obj;
            });
            params.columns.forEach(function (title, i) {
                params.columns[i] = {title: title, key: i};
            });
        } else {
            // Use options as is
        }
    }

    function initOptions(raw) {
        settings = defaultOptions();
        Object.keys(raw).forEach(function (key) {
            settings[key] = raw[key];
        });
        doc.setFontSize(settings.fontSize);

        // Backwards compatibility
        if(settings.margins.horizontal !== undefined) {
            settings.margins.left = settings.margins.horizontal;
            settings.margins.right = settings.margins.horizontal;
        } else {
            settings.margins.horizontal = settings.margins.left;
        }
    }

    function calculateColumnWidths(rows, columns) {
        var widths = {};

        // Optimal widths
        var optimalTableWidth = 0;
        columns.forEach(function (header) {
            var widest = getStringWidth(header.title || '', true);
            if(typeof header.width == "number") {
                widest = header.width;
            } else {
                rows.forEach(function (row) {
                    if (!header.hasOwnProperty('key'))
                        throw new Error("The key attribute is required in every header");
                    var w = getStringWidth(stringify(row, header.key));
                    if (w > widest) {
                        widest = w;
                    }
                });
            }
            widths[header.key] = widest;
            optimalTableWidth += widest;
        });

        var paddingAndMargin = settings.padding * 2 * columns.length + settings.margins.left + settings.margins.right;
        var spaceDiff = doc.internal.pageSize.width - optimalTableWidth - paddingAndMargin;

        var keys = Object.keys(widths);
        if (spaceDiff < 0) {
            // Shrink columns
            var shrinkableColumns = [];
            var shrinkableColumnWidths = 0;
            if (settings.overflowColumns === false) {
                keys.forEach(function (key) {
                    if (widths[key] > MIN_COLUMN_WIDTH) {
                        shrinkableColumns.push(key);
                        shrinkableColumnWidths += widths[key];
                    }
                });
            } else {
                shrinkableColumns = settings.overflowColumns;
                shrinkableColumns.forEach(function (col) {
                    shrinkableColumnWidths += widths[col];
                });
            }

            shrinkableColumns.forEach(function (key) {
                widths[key] += spaceDiff * (widths[key] / shrinkableColumnWidths);
            });
        } else if (spaceDiff > 0 && settings.extendWidth) {
            // Fill page horizontally
            keys.forEach(function (key) {
                widths[key] += spaceDiff / keys.length;
            });
        }

        return widths;
    }

    function printHeader(headers, columnWidths) {
        if (!headers) return;

        // First calculate the height of the row
        // (to do that the maxium amount of rows first need to be found)
        var maxRows = 1;
        if (settings.overflow === 'linebreak') {
            // Font style must be the same as in function renderHeaderCell()
            doc.setFontStyle('bold');

            headers.forEach(function (header) {
                if (isOverflowColumn(header)) {
                    var value = header.title || '';
                    var arr = doc.splitTextToSize(value, columnWidths[header.key]);
                    if (arr.length > maxRows) {
                        maxRows = arr.length;
                    }
                }
            });
        }
        var rowHeight = settings.lineHeight + (maxRows - 1) * API.autoTableTextHeight() + 5;

        // Avoid isolated table headers when drawing multiple tables. Add a new page 
        // if cellpos would be at the end of page after drawing the header row
        var newPage = (cellPos.y + settings.margins.bottom + rowHeight * 2) >= doc.internal.pageSize.height;
        if (newPage) {
            settings.renderFooter(doc, cellPos, pageCount, settings);
            doc.addPage();
            cellPos = {x: settings.margins.left, y: settings.margins.top};
            pageCount++;
            settings.renderHeader(doc, pageCount, settings);
        }

        headers.forEach(function (header) {
            var width = columnWidths[header.key] + settings.padding * 2;
            var value = header.title || '';
            if (settings.overflow === 'linebreak') {
                if (isOverflowColumn(header)) {
                    value = doc.splitTextToSize(value, columnWidths[header.key]);
                }
            } else if (settings.overflow === 'ellipsize') {
                value = ellipsize(columnWidths[header.key], value);
            }
            settings.renderHeaderCell(cellPos.x, cellPos.y, width, rowHeight, header.key, value, settings);
            cellPos.x += width;
        });
        doc.setTextColor(70, 70, 70);
        doc.setFontStyle('normal');

        cellPos.y += rowHeight;
        cellPos.x = settings.margins.left;
    }

    function printRows(headers, rows, columnWidths) {
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];

            // First calculate the height of the row
            // (to do that the maxium amount of rows first need to be found)
            var maxRows = 1;
            if (settings.overflow === 'linebreak') {
                headers.forEach(function (header) {
                    if (isOverflowColumn(header)) {
                        var value = stringify(row, header.key);
                        var arr = doc.splitTextToSize(value, columnWidths[header.key]);
                        if (arr.length > maxRows) {
                            maxRows = arr.length;
                        }
                    }
                });
            }
            var rowHeight = settings.lineHeight + (maxRows - 1) * API.autoTableTextHeight();


            // Render the cell
            headers.forEach(function (header) {
                var value = stringify(row, header.key);
                if (settings.overflow === 'linebreak') {
                    if (isOverflowColumn(header)) {
                        value = doc.splitTextToSize(value, columnWidths[header.key]);
                    }
                } else if (settings.overflow === 'ellipsize') {
                    value = ellipsize(columnWidths[header.key], value);
                }
                var width = columnWidths[header.key] + settings.padding * 2;
                settings.renderCell(cellPos.x, cellPos.y, width, rowHeight, header.key, value, i, settings);
                cellPos.x = cellPos.x + columnWidths[header.key] + settings.padding * 2;
            });

            // Add a new page if cellpos is at the end of page
            var newPage = (cellPos.y + settings.margins.bottom + rowHeight * 2) >= doc.internal.pageSize.height;
            if (newPage) {
                if (i+1 < rows.length) {
                    settings.renderFooter(doc, cellPos, pageCount, settings);
                    doc.addPage();
                    cellPos = {x: settings.margins.left, y: settings.margins.top};
                    pageCount++;
                    settings.renderHeader(doc, pageCount, settings);
                    printHeader(headers, columnWidths);
                }
            } else {
                cellPos.y += rowHeight;
                cellPos.x = settings.margins.left;
            }
        }
    }

    function isOverflowColumn(header) {
        return settings.overflowColumns === false || settings.overflowColumns.indexOf(header.key) !== -1;
    }

    /**
     * Ellipsize the text to fit in the width
     * @param width
     * @param text
     */
    function ellipsize(width, text) {
        if (width >= getStringWidth(text)) {
            return text;
        }
        while (width < getStringWidth(text + "...")) {
            if (text.length < 2) {
                break;
            }
            text = text.substring(0, text.length - 1);
        }
        text += "...";
        return text;
    }

    function stringify(row, key) {
        return row.hasOwnProperty(key) ? '' + row[key] : '';
    }

    function getStringWidth(txt, isBold) {
        if(isBold) {
            doc.setFontStyle('bold');
        }
        var strWidth = doc.getStringUnitWidth(txt) * doc.internal.getFontSize();
        if(isBold) {
            doc.setFontStyle('normal');
        }
        return strWidth;
    }

})(jsPDF.API);
