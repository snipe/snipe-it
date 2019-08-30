/**
 * @preserve tableExport.jquery.plugin
 *
 * Version 1.9.8
 *
 * Copyright (c) 2015-2017 hhurz, https://github.com/hhurz
 *
 * Original Work Copyright (c) 2014 Giri Raj
 *
 * Licensed under the MIT License
 **/

(function ($) {
    $.fn.extend({
        tableExport: function (options) {
            var defaults = {
                consoleLog:        false,
                csvEnclosure:      '"',
                csvSeparator:      ',',
                csvUseBOM:         true,
                displayTableName:  false,
                escape:            false,
                excelFileFormat:   'xlshtml',     // xmlss = XML Spreadsheet 2003 file format (XMLSS), xlshtml = Excel 2000 html format
                excelRTL:          false,         // true = Set Excel option 'DisplayRightToLeft'
                excelstyles:       [],            // e.g. ['border-bottom', 'border-top', 'border-left', 'border-right']
                exportHiddenCells: false,         // true = speed up export of large tables with hidden cells (hidden cells will be exported !)
                fileName:          'tableExport',
                htmlContent:       false,
                ignoreColumn:      [],
                ignoreRow:         [],
                jsonScope:         'all',         // head, data, all
                jspdf: {
                    orientation:  'p',
                    unit:         'pt',
                    format:       'a4',             // jspdf page format or 'bestfit' for autmatic paper format selection
                    margins:      {left: 20, right: 10, top: 10, bottom: 10},
                    onDocCreated: null,
                    autotable: {
                        styles: {
                            cellPadding: 2,
                            rowHeight:   12,
                            fontSize:    8,
                            fillColor:   255,           // color value or 'inherit' to use css background-color from html table
                            textColor:   50,            // color value or 'inherit' to use css color from html table
                            fontStyle:   'normal',      // normal, bold, italic, bolditalic or 'inherit' to use css font-weight and fonst-style from html table
                            overflow:    'ellipsize',   // visible, hidden, ellipsize or linebreak
                            halign:      'left',        // left, center, right
                            valign:      'middle'       // top, middle, bottom
                        },
                        headerStyles: {
                            fillColor: [52, 73, 94],
                            textColor: 255,
                            fontStyle: 'bold',
                            halign:    'center'
                        },
                        alternateRowStyles: {
                            fillColor: 245
                        },
                        tableExport: {
                            doc:               null,    // jsPDF doc object. If set, an already created doc will be used to export to
                            onAfterAutotable:  null,
                            onBeforeAutotable: null,
                            onAutotableText:   null,
                            onTable:           null,
                            outputImages:      true
                        }
                    }
                },
                numbers: {
                    html: {
                        decimalMark:        '.',
                        thousandsSeparator: ','
                    },
                    output: {                       // set output: false to keep number format in exported output
                        decimalMark:        '.',
                        thousandsSeparator: ','
                    }
                },
                onCellData:        null,
                onCellHtmlData:    null,
                onIgnoreRow:       null,          // onIgnoreRow($tr, rowIndex): function should return true to not export a row
                onMsoNumberFormat: null,          // Excel 2000 html format only. See readme.md for more information about msonumberformat
                outputMode:        'file',        // 'file', 'string', 'base64' or 'window' (experimental)
                pdfmake: {
                    enabled: false,                 // true: use pdfmake instead of jspdf and jspdf-autotable (experimental)
                    docDefinition: {
                        pageOrientation: 'portrait',  // 'portrait' or 'landscape'
                        defaultStyle: {
                            font: 'Roboto'              // default is 'Roboto', for arabic font set this option to 'Mirza' and include mirza_fonts.js
                        }
                    },
                    fonts: {}
                },
                tbodySelector:     'tr',
                tfootSelector:     'tr',          // set empty ('') to prevent export of tfoot rows
                theadSelector:     'tr',
                tableName:         'Table',
                type:              'csv',         // 'csv', 'tsv', 'txt', 'sql', 'json', 'xml', 'excel', 'doc', 'png' or 'pdf'
                worksheetName:     ''
            };

            var FONT_ROW_RATIO = 1.15;
            var el             = this;
            var DownloadEvt    = null;
            var $hrows         = [];
            var $rows          = [];
            var rowIndex       = 0;
            var trData         = '';
            var colNames       = [];
            var ranges         = [];
            var blob;
            var $hiddenTableElements = [];
            var checkCellVisibilty = false;

            $.extend(true, defaults, options);

            colNames = GetColumnNames(el);

            if ( defaults.type == 'csv' || defaults.type == 'tsv' || defaults.type == 'txt' ) {

                var csvData   = "";
                var rowlength = 0;
                ranges        = [];
                rowIndex      = 0;

                function csvString (cell, rowIndex, colIndex) {
                    var result = '';

                    if ( cell !== null ) {
                        var dataString = parseString(cell, rowIndex, colIndex);

                        var csvValue = (dataString === null || dataString === '') ? '' : dataString.toString();

                        if ( defaults.type == 'tsv' ) {
                            if ( dataString instanceof Date )
                                dataString.toLocaleString();

                            // According to http://www.iana.org/assignments/media-types/text/tab-separated-values
                            // are fields that contain tabs not allowable in tsv encoding
                            result = replaceAll(csvValue, '\t', ' ');
                        }
                        else {
                            // Takes a string and encapsulates it (by default in double-quotes) if it
                            // contains the csv field separator, spaces, or linebreaks.
                            if ( dataString instanceof Date )
                                result = defaults.csvEnclosure + dataString.toLocaleString() + defaults.csvEnclosure;
                            else {
                                result = replaceAll(csvValue, defaults.csvEnclosure, defaults.csvEnclosure + defaults.csvEnclosure);

                                if ( result.indexOf(defaults.csvSeparator) >= 0 || /[\r\n ]/g.test(result) )
                                    result = defaults.csvEnclosure + result + defaults.csvEnclosure;
                            }
                        }
                    }

                    return result;
                }

                var CollectCsvData = function ($rows, rowselector, length) {

                    $rows.each(function () {
                        trData = "";
                        ForEachVisibleCell(this, rowselector, rowIndex, length + $rows.length,
                            function (cell, row, col) {
                                trData += csvString(cell, row, col) + (defaults.type == 'tsv' ? '\t' : defaults.csvSeparator);
                            });
                        trData = $.trim(trData).substring(0, trData.length - 1);
                        if ( trData.length > 0 ) {

                            if ( csvData.length > 0 )
                                csvData += "\n";

                            csvData += trData;
                        }
                        rowIndex++;
                    });

                    return $rows.length;
                };

                rowlength += CollectCsvData($(el).find('thead').first().find(defaults.theadSelector), 'th,td', rowlength);
                findTablePart($(el),'tbody').each(function () {
                    rowlength += CollectCsvData(findRows($(this), defaults.tbodySelector), 'td,th', rowlength);
                });
                if ( defaults.tfootSelector.length )
                    CollectCsvData($(el).find('tfoot').first().find(defaults.tfootSelector), 'td,th', rowlength);

                csvData += "\n";

                //output
                if ( defaults.consoleLog === true )
                    console.log(csvData);

                if ( defaults.outputMode === 'string' )
                    return csvData;

                if ( defaults.outputMode === 'base64' )
                    return base64encode(csvData);

                if ( defaults.outputMode === 'window' ) {
                    downloadFile(false, 'data:text/' + (defaults.type == 'csv' ? 'csv' : 'plain') + ';charset=utf-8,', csvData);
                    return;
                }

                try {
                    blob = new Blob([csvData], {type: "text/" + (defaults.type == 'csv' ? 'csv' : 'plain') + ";charset=utf-8"});
                    saveAs(blob, defaults.fileName + '.' + defaults.type, (defaults.type != 'csv' || defaults.csvUseBOM === false));
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.' + defaults.type,
                        'data:text/' + (defaults.type == 'csv' ? 'csv' : 'plain') + ';charset=utf-8,' + ((defaults.type == 'csv' && defaults.csvUseBOM) ? '\ufeff' : ''),
                        csvData);
                }

            } else if ( defaults.type == 'sql' ) {

                // Header
                rowIndex = 0;
                ranges   = [];
                var tdData = "INSERT INTO `" + defaults.tableName + "` (";
                $hrows     = $(el).find('thead').first().find(defaults.theadSelector);
                $hrows.each(function () {
                    ForEachVisibleCell(this, 'th,td', rowIndex, $hrows.length,
                        function (cell, row, col) {
                            tdData += "'" + parseString(cell, row, col) + "',";
                        });
                    rowIndex++;
                    tdData = $.trim(tdData);
                    tdData = $.trim(tdData).substring(0, tdData.length - 1);
                });
                tdData += ") VALUES ";

                // Data
                $rows = collectRows ($(el));
                $($rows).each(function () {
                    trData = "";
                    ForEachVisibleCell(this, 'td,th', rowIndex, $hrows.length + $rows.length,
                        function (cell, row, col) {
                            trData += "'" + parseString(cell, row, col) + "',";
                        });
                    if ( trData.length > 3 ) {
                        tdData += "(" + trData;
                        tdData = $.trim(tdData).substring(0, tdData.length - 1);
                        tdData += "),";
                    }
                    rowIndex++;
                });

                tdData = $.trim(tdData).substring(0, tdData.length - 1);
                tdData += ";";

                // Output
                if ( defaults.consoleLog === true )
                    console.log(tdData);

                if ( defaults.outputMode === 'string' )
                    return tdData;

                if ( defaults.outputMode === 'base64' )
                    return base64encode(tdData);

                try {
                    blob = new Blob([tdData], {type: "text/plain;charset=utf-8"});
                    saveAs(blob, defaults.fileName + '.sql');
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.sql',
                        'data:application/sql;charset=utf-8,',
                        tdData);
                }

            } else if ( defaults.type == 'json' ) {
                var jsonHeaderArray = [];
                ranges = [];
                $hrows = $(el).find('thead').first().find(defaults.theadSelector);
                $hrows.each(function () {
                    var jsonArrayTd = [];

                    ForEachVisibleCell(this, 'th,td', rowIndex, $hrows.length,
                        function (cell, row, col) {
                            jsonArrayTd.push(parseString(cell, row, col));
                        });
                    jsonHeaderArray.push(jsonArrayTd);
                });

                // Data
                var jsonArray = [];

                $rows = collectRows ($(el));
                $($rows).each(function () {
                    var jsonObjectTd = {};
                    var colIndex = 0;

                    ForEachVisibleCell(this, 'td,th', rowIndex, $hrows.length + $rows.length,
                        function (cell, row, col) {
                            if ( jsonHeaderArray.length ) {
                                jsonObjectTd[jsonHeaderArray[jsonHeaderArray.length - 1][colIndex]] = parseString(cell, row, col);
                            } else {
                                jsonObjectTd[colIndex] = parseString(cell, row, col);
                            }
                            colIndex++;
                        });
                    if ( $.isEmptyObject(jsonObjectTd) === false )
                        jsonArray.push(jsonObjectTd);

                    rowIndex++;
                });

                var sdata = "";

                if ( defaults.jsonScope == 'head' )
                    sdata = JSON.stringify(jsonHeaderArray);
                else if ( defaults.jsonScope == 'data' )
                    sdata = JSON.stringify(jsonArray);
                else // all
                    sdata = JSON.stringify({header: jsonHeaderArray, data: jsonArray});

                if ( defaults.consoleLog === true )
                    console.log(sdata);

                if ( defaults.outputMode === 'string' )
                    return sdata;

                if ( defaults.outputMode === 'base64' )
                    return base64encode(sdata);

                try {
                    blob = new Blob([sdata], {type: "application/json;charset=utf-8"});
                    saveAs(blob, defaults.fileName + '.json');
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.json',
                        'data:application/json;charset=utf-8;base64,',
                        sdata);
                }

            } else if ( defaults.type === 'xml' ) {
                rowIndex = 0;
                ranges   = [];
                var xml  = '<?xml version="1.0" encoding="utf-8"?>';
                xml += '<tabledata><fields>';

                // Header
                $hrows = $(el).find('thead').first().find(defaults.theadSelector);
                $hrows.each(function () {

                    ForEachVisibleCell(this, 'th,td', rowIndex, $hrows.length,
                        function (cell, row, col) {
                            xml += "<field>" + parseString(cell, row, col) + "</field>";
                        });
                    rowIndex++;
                });
                xml += '</fields><data>';

                // Data
                var rowCount = 1;

                $rows = collectRows ($(el));
                $($rows).each(function () {
                    var colCount = 1;
                    trData       = "";
                    ForEachVisibleCell(this, 'td,th', rowIndex, $hrows.length + $rows.length,
                        function (cell, row, col) {
                            trData += "<column-" + colCount + ">" + parseString(cell, row, col) + "</column-" + colCount + ">";
                            colCount++;
                        });
                    if ( trData.length > 0 && trData != "<column-1></column-1>" ) {
                        xml += '<row id="' + rowCount + '">' + trData + '</row>';
                        rowCount++;
                    }

                    rowIndex++;
                });
                xml += '</data></tabledata>';

                // Output
                if ( defaults.consoleLog === true )
                    console.log(xml);

                if ( defaults.outputMode === 'string' )
                    return xml;

                if ( defaults.outputMode === 'base64' )
                    return base64encode(xml);

                try {
                    blob = new Blob([xml], {type: "application/xml;charset=utf-8"});
                    saveAs(blob, defaults.fileName + '.xml');
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.xml',
                        'data:application/xml;charset=utf-8;base64,',
                        xml);
                }
            }
            else if ( defaults.type === 'excel' && defaults.excelFileFormat === 'xmlss' ) {
                var docDatas = [];
                var docNames = [];

                $(el).filter(function () {
                    return isVisible($(this));
                }).each(function () {
                    var $table  = $(this);

                    var ssName = '';
                    if ( typeof defaults.worksheetName === 'string' && defaults.worksheetName.length )
                        ssName = defaults.worksheetName + ' ' + (docNames.length + 1);
                    else if ( typeof defaults.worksheetName[docNames.length] !== 'undefined' )
                        ssName = defaults.worksheetName[docNames.length];
                    if ( ! ssName.length )
                        ssName = $table.find('caption').text() || '';
                    if ( ! ssName.length )
                        ssName = 'Table ' + (docNames.length + 1);
                    ssName = ssName.replace(/[\\\/[\]*:?'"]/g,'').substring(0,31).trim();

                    docNames.push($('<div />').text(ssName).html());

                    if ( defaults.exportHiddenCells === false ) {
                        $hiddenTableElements = $table.find("tr, th, td").filter(":hidden");
                        checkCellVisibilty = $hiddenTableElements.length > 0;
                    }

                    rowIndex = 0;
                    colNames = GetColumnNames(this);
                    docData  = '<Table>\r';

                    function CollectXmlssData ($rows, rowselector, length) {
                        var spans = [];

                        $($rows).each(function () {
                            var ssIndex = 0;
                            var nCols = 0;
                            trData   = "";

                            ForEachVisibleCell(this, 'td,th', rowIndex, length + $rows.length,
                                function (cell, row, col) {
                                    if ( cell !== null ) {
                                        var style = "";
                                        var data  = parseString(cell, row, col);
                                        var type  = "String";

                                        if ( jQuery.isNumeric(data) !== false ) {
                                            type = "Number";
                                        }
                                        else {
                                            var number = parsePercent(data);
                                            if ( number !== false ) {
                                                data  = number;
                                                type  = "Number";
                                                style += ' ss:StyleID="pct1"';
                                            }
                                        }

                                        if ( type !== "Number" )
                                            data = data.replace(/\n/g, '<br>');

                                        var colspan = parseInt(cell.getAttribute('colspan'));
                                        var rowspan = parseInt(cell.getAttribute('rowspan'));

                                        // Skip spans
                                        spans.forEach(function (range) {
                                            if ( rowIndex >= range.s.r && rowIndex <= range.e.r && nCols >= range.s.c && nCols <= range.e.c ) {
                                                for ( var i = 0; i <= range.e.c - range.s.c; ++i ) {
                                                    nCols++;
                                                    ssIndex++;
                                                }
                                            }
                                        });

                                        // Handle Row Span
                                        if ( rowspan || colspan ) {
                                            rowspan = rowspan || 1;
                                            colspan = colspan || 1;
                                            spans.push({
                                                s: {r: rowIndex, c: nCols},
                                                e: {r: rowIndex + rowspan - 1, c: nCols + colspan - 1}
                                            });
                                        }

                                        // Handle Colspan
                                        if ( colspan > 1 ) {
                                            style += ' ss:MergeAcross="' + (colspan-1) + '"';
                                            nCols += (colspan - 1);
                                        }

                                        if ( rowspan > 1 ) {
                                            style += ' ss:MergeDown="' + (rowspan-1) + '" ss:StyleID="rsp1"';
                                        }

                                        if ( ssIndex > 0 ) {
                                            style += ' ss:Index="' + (nCols+1) + '"';
                                            ssIndex = 0;
                                        }

                                        trData += '<Cell' + style + '><Data ss:Type="' + type + '">' +
                                            $('<div />').text(data).html() +
                                            '</Data></Cell>\r';
                                        nCols++;
                                    }
                                });
                            if ( trData.length > 0 )
                                docData += '<Row ss:AutoFitHeight="0">\r' + trData + '</Row>\r';
                            rowIndex++;
                        });

                        return $rows.length;
                    }

                    var rowLength = 0;
                    rowLength += CollectXmlssData ($table.find('thead').first().find(defaults.theadSelector), 'th,td', rowLength);
                    CollectXmlssData (collectRows ($table), 'td,th', rowLength);

                    docData += '</Table>\r';
                    docDatas.push(docData);

                    if ( defaults.consoleLog === true )
                        console.log(docData);
                });

                var count = {};
                var firstOccurences = {};
                var item, itemCount;
                for (var n = 0, c = docNames.length; n < c; n++)
                {
                    item = docNames[n];
                    itemCount = count[item];
                    itemCount = count[item] = (itemCount == null ? 1 : itemCount + 1);

                    if( itemCount == 2 )
                        docNames[firstOccurences[item]] = docNames[firstOccurences[item]].substring(0,29) + "-1";
                    if( count[ item ] > 1 )
                        docNames[n] = docNames[n].substring(0,29) + "-" + count[item];
                    else
                        firstOccurences[item] = n;
                }

                var CreationDate = new Date().toISOString();
                var xmlssDocFile = '<?xml version="1.0" encoding="UTF-8"?>\r' +
                    '<?mso-application progid="Excel.Sheet"?>\r' +
                    '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"\r' +
                    ' xmlns:o="urn:schemas-microsoft-com:office:office"\r' +
                    ' xmlns:x="urn:schemas-microsoft-com:office:excel"\r' +
                    ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"\r' +
                    ' xmlns:html="http://www.w3.org/TR/REC-html40">\r' +
                    '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">\r' +
                    '  <Created>' + CreationDate + '</Created>\r' +
                    '</DocumentProperties>\r' +
                    '<OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">\r' +
                    '  <AllowPNG/>\r' +
                    '</OfficeDocumentSettings>\r' +
                    '<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">\r' +
                    '  <WindowHeight>9000</WindowHeight>\r' +
                    '  <WindowWidth>13860</WindowWidth>\r' +
                    '  <WindowTopX>0</WindowTopX>\r' +
                    '  <WindowTopY>0</WindowTopY>\r' +
                    '  <ProtectStructure>False</ProtectStructure>\r' +
                    '  <ProtectWindows>False</ProtectWindows>\r' +
                    '</ExcelWorkbook>\r' +
                    '<Styles>\r' +
                    '  <Style ss:ID="Default" ss:Name="Normal">\r' +
                    '    <Alignment ss:Vertical="Bottom"/>\r' +
                    '    <Borders/>\r' +
                    '    <Font/>\r' +
                    '    <Interior/>\r' +
                    '    <NumberFormat/>\r' +
                    '    <Protection/>\r' +
                    '  </Style>\r' +
                    '  <Style ss:ID="rsp1">\r' +
                    '    <Alignment ss:Vertical="Center"/>\r' +
                    '  </Style>\r' +
                    '  <Style ss:ID="pct1">\r' +
                    '    <NumberFormat ss:Format="Percent"/>\r' +
                    '  </Style>\r' +
                    '</Styles>\r';

                for ( var j = 0; j < docDatas.length; j++ ) {
                    xmlssDocFile += '<Worksheet ss:Name="' + docNames[j] + '" ss:RightToLeft="' + (defaults.excelRTL ? '1' : '0') + '">\r' +
                        docDatas[j];
                    if (defaults.excelRTL) {
                        xmlssDocFile += '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">\r' +
                            '<DisplayRightToLeft/>\r' +
                            '</WorksheetOptions>\r';
                    }
                    else
                        xmlssDocFile += '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel"/>\r';
                    xmlssDocFile += '</Worksheet>\r';
                }

                xmlssDocFile += '</Workbook>\r';

                if ( defaults.consoleLog === true )
                    console.log(xmlssDocFile);

                if ( defaults.outputMode === 'string' )
                    return xmlssDocFile;

                if ( defaults.outputMode === 'base64' )
                    return base64encode(xmlssDocFile);

                try {
                    blob = new Blob([xmlssDocFile], {type: "application/xml;charset=utf-8"});
                    saveAs(blob, defaults.fileName + '.xml');
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.xml',
                        'data:application/xml;charset=utf-8;base64,',
                        xmlssDocFile);
                }
            }
            else if ( defaults.type == 'excel' || defaults.type == 'xls' || defaults.type == 'word' || defaults.type == 'doc' ) {

                var MSDocType   = (defaults.type == 'excel' || defaults.type == 'xls') ? 'excel' : 'word';
                var MSDocExt    = (MSDocType == 'excel') ? 'xls' : 'doc';
                var MSDocSchema = 'xmlns:x="urn:schemas-microsoft-com:office:' + MSDocType + '"';
                var docData     = '';
                var docName     = '';

                $(el).filter(function () {
                    return isVisible($(this));
                }).each(function () {
                    var $table = $(this);

                    if (docName === '') {
                        docName = defaults.worksheetName || $table.find('caption').text() || 'Table';
                        docName = docName.replace(/[\\\/[\]*:?'"]/g, '').substring(0, 31).trim();
                    }

                    if ( defaults.exportHiddenCells === false ) {
                        $hiddenTableElements = $table.find("tr, th, td").filter(":hidden");
                        checkCellVisibilty = $hiddenTableElements.length > 0;
                    }

                    rowIndex = 0;
                    ranges   = [];
                    colNames = GetColumnNames(this);

                    // Header
                    docData += '<table><thead>';
                    $hrows = $table.find('thead').first().find(defaults.theadSelector);
                    $hrows.each(function () {
                        trData = "";
                        ForEachVisibleCell(this, 'th,td', rowIndex, $hrows.length,
                            function (cell, row, col) {
                                if ( cell !== null ) {
                                    var thstyle = '';
                                    trData += '<th';
                                    for ( var styles in defaults.excelstyles ) {
                                        if ( defaults.excelstyles.hasOwnProperty(styles) ) {
                                            var thcss = $(cell).css(defaults.excelstyles[styles]);
                                            if ( thcss !== '' && thcss != '0px none rgb(0, 0, 0)' && thcss != 'rgba(0, 0, 0, 0)' ) {
                                                thstyle += (thstyle === '') ? 'style="' : ';';
                                                thstyle += defaults.excelstyles[styles] + ':' + thcss;
                                            }
                                        }
                                    }
                                    if ( thstyle !== '' )
                                        trData += ' ' + thstyle + '"';
                                    if ( $(cell).is("[colspan]") )
                                        trData += ' colspan="' + $(cell).attr('colspan') + '"';
                                    if ( $(cell).is("[rowspan]") )
                                        trData += ' rowspan="' + $(cell).attr('rowspan') + '"';
                                    trData += '>' + parseString(cell, row, col) + '</th>';
                                }
                            });
                        if ( trData.length > 0 )
                            docData += '<tr>' + trData + '</tr>';
                        rowIndex++;
                    });
                    docData += '</thead><tbody>';

                    // Data
                    $rows = collectRows ($table);
                    $($rows).each(function () {
                        var $row = $(this);
                        trData   = "";
                        ForEachVisibleCell(this, 'td,th', rowIndex, $hrows.length + $rows.length,
                            function (cell, row, col) {
                                if ( cell !== null ) {
                                    var tdvalue = parseString(cell, row, col);
                                    var tdstyle = '';
                                    var tdcss   = $(cell).data("tableexport-msonumberformat");

                                    if ( typeof tdcss == 'undefined' && typeof defaults.onMsoNumberFormat === 'function' )
                                        tdcss = defaults.onMsoNumberFormat(cell, row, col);

                                    if ( typeof tdcss != 'undefined' && tdcss !== '' )
                                        tdstyle = 'style="mso-number-format:\'' + tdcss + '\'';

                                    for ( var cssStyle in defaults.excelstyles ) {
                                        if ( defaults.excelstyles.hasOwnProperty(cssStyle) ) {
                                            tdcss = $(cell).css(defaults.excelstyles[cssStyle]);
                                            if ( tdcss === '' )
                                                tdcss = $row.css(defaults.excelstyles[cssStyle]);

                                            if ( tdcss !== '' && tdcss != '0px none rgb(0, 0, 0)' && tdcss != 'rgba(0, 0, 0, 0)' ) {
                                                tdstyle += (tdstyle === '') ? 'style="' : ';';
                                                tdstyle += defaults.excelstyles[cssStyle] + ':' + tdcss;
                                            }
                                        }
                                    }
                                    trData += '<td';
                                    if ( tdstyle !== '' )
                                        trData += ' ' + tdstyle + '"';
                                    if ( $(cell).is("[colspan]") )
                                        trData += ' colspan="' + $(cell).attr('colspan') + '"';
                                    if ( $(cell).is("[rowspan]") )
                                        trData += ' rowspan="' + $(cell).attr('rowspan') + '"';

                                    if ( typeof tdvalue === 'string' && tdvalue != '' )
                                        tdvalue = tdvalue.replace(/\n/g, '<br>');

                                    trData += '>' + tdvalue + '</td>';
                                }
                            });
                        if ( trData.length > 0 )
                            docData += '<tr>' + trData + '</tr>';
                        rowIndex++;
                    });

                    if ( defaults.displayTableName )
                        docData += '<tr><td></td></tr><tr><td></td></tr><tr><td>' + parseString($('<p>' + defaults.tableName + '</p>')) + '</td></tr>';

                    docData += '</tbody></table>';

                    if ( defaults.consoleLog === true )
                        console.log(docData);
                });

                //noinspection XmlUnusedNamespaceDeclaration
                var docFile = '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' + MSDocSchema + ' xmlns="http://www.w3.org/TR/REC-html40">';
                docFile += '<meta http-equiv="content-type" content="application/vnd.ms-' + MSDocType + '; charset=UTF-8">';
                docFile += "<head>";
                if (MSDocType === 'excel') {
                    docFile += "<!--[if gte mso 9]>";
                    docFile += "<xml>";
                    docFile += "<x:ExcelWorkbook>";
                    docFile += "<x:ExcelWorksheets>";
                    docFile += "<x:ExcelWorksheet>";
                    docFile += "<x:Name>";
                    docFile += docName;
                    docFile += "</x:Name>";
                    docFile += "<x:WorksheetOptions>";
                    docFile += "<x:DisplayGridlines/>";
                    if (defaults.excelRTL)
                        docFile += "<x:DisplayRightToLeft/>";
                    docFile += "</x:WorksheetOptions>";
                    docFile += "</x:ExcelWorksheet>";
                    docFile += "</x:ExcelWorksheets>";
                    docFile += "</x:ExcelWorkbook>";
                    docFile += "</xml>";
                    docFile += "<![endif]-->";
                }
                docFile += "<style>br {mso-data-placement:same-cell;}</style>";
                docFile += "</head>";
                docFile += "<body>";
                docFile += docData;
                docFile += "</body>";
                docFile += "</html>";

                if ( defaults.consoleLog === true )
                    console.log(docFile);

                if ( defaults.outputMode === 'string' )
                    return docFile;

                if ( defaults.outputMode === 'base64' )
                    return base64encode(docFile);

                try {
                    blob = new Blob([docFile], {type: 'application/vnd.ms-' + defaults.type});
                    saveAs(blob, defaults.fileName + '.' + MSDocExt);
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.' + MSDocExt,
                        'data:application/vnd.ms-' + MSDocType + ';base64,',
                        docFile);
                }

            } else if ( defaults.type == 'xlsx' ) {

                var data  = [];
                var spans = [];
                rowIndex  = 0;

                $rows = $(el).find('thead').first().find(defaults.theadSelector);
                $rows.push.apply($rows, collectRows ($(el)));

                $($rows).each(function () {
                    var cols = [];
                    ForEachVisibleCell(this, 'th,td', rowIndex, $rows.length,
                        function (cell, row, col) {
                            if ( typeof cell !== 'undefined' && cell !== null ) {

                                var cellValue = parseString(cell, row, col);

                                var colspan = parseInt(cell.getAttribute('colspan'));
                                var rowspan = parseInt(cell.getAttribute('rowspan'));

                                // Skip span ranges
                                spans.forEach(function (range) {
                                    if ( rowIndex >= range.s.r && rowIndex <= range.e.r && cols.length >= range.s.c && cols.length <= range.e.c ) {
                                        for ( var i = 0; i <= range.e.c - range.s.c; ++i )
                                            cols.push(null);
                                    }
                                });

                                // Handle Row Span
                                if ( rowspan || colspan ) {
                                    rowspan = rowspan || 1;
                                    colspan = colspan || 1;
                                    spans.push({
                                        s: {r: rowIndex, c: cols.length},
                                        e: {r: rowIndex + rowspan - 1, c: cols.length + colspan - 1}
                                    });
                                }

                                // Handle Value
                                if ( typeof defaults.onCellData !== 'function' ) {

                                    // Type conversion
                                    if ( cellValue !== "" && cellValue == +cellValue )
                                        cellValue = +cellValue;
                                }
                                cols.push(cellValue !== "" ? cellValue : null);

                                // Handle Colspan
                                if ( colspan )
                                    for ( var k = 0; k < colspan - 1; ++k )
                                        cols.push(null);
                            }
                        });
                    data.push(cols);
                    rowIndex++;
                });

                //noinspection JSPotentiallyInvalidConstructorUsage
                var wb = new jx_Workbook(),
                    ws = jx_createSheet(data);

                // add span ranges to worksheet
                ws['!merges'] = spans;

                // add worksheet to workbook
                wb.SheetNames.push(defaults.worksheetName);
                wb.Sheets[defaults.worksheetName] = ws;

                var wbout = XLSX.write(wb, {bookType: defaults.type, bookSST: false, type: 'binary'});

                try {
                    blob = new Blob([jx_s2ab(wbout)], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8'});
                    saveAs(blob, defaults.fileName + '.' + defaults.type);
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.' + defaults.type,
                        'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8,',
                        jx_s2ab(wbout));
                }

            } else if ( defaults.type == 'png' ) {
                //html2canvas($(el)[0], {
                //  onrendered: function (canvas) {
                html2canvas($(el)[0]).then(
                    function (canvas) {

                        var image      = canvas.toDataURL();
                        var byteString = atob(image.substring(22)); // remove data stuff
                        var buffer     = new ArrayBuffer(byteString.length);
                        var intArray   = new Uint8Array(buffer);

                        for ( var i = 0; i < byteString.length; i++ )
                            intArray[i] = byteString.charCodeAt(i);

                        if ( defaults.consoleLog === true )
                            console.log(byteString);

                        if ( defaults.outputMode === 'string' )
                            return byteString;

                        if ( defaults.outputMode === 'base64' )
                            return base64encode(image);

                        if ( defaults.outputMode === 'window' ) {
                            window.open(image);
                            return;
                        }

                        try {
                            blob = new Blob([buffer], {type: "image/png"});
                            saveAs(blob, defaults.fileName + '.png');
                        }
                        catch (e) {
                            downloadFile(defaults.fileName + '.png', 'data:image/png,', blob);
                        }
                        //}
                    });

            } else if ( defaults.type == 'pdf' ) {

                if ( defaults.pdfmake.enabled === true ) {
                    // pdf output using pdfmake
                    // https://github.com/bpampuch/pdfmake

                    var widths = [];
                    var body   = [];
                    rowIndex   = 0;
                    ranges     = [];

                    var CollectPdfmakeData = function ($rows, colselector, length) {
                        var rlength = 0;

                        $($rows).each(function () {
                            var r = [];

                            ForEachVisibleCell(this, colselector, rowIndex, length,
                                function (cell, row, col) {
                                    if ( typeof cell !== 'undefined' && cell !== null ) {

                                        var colspan = parseInt(cell.getAttribute('colspan'));
                                        var rowspan = parseInt(cell.getAttribute('rowspan'));

                                        var cellValue = parseString(cell, row, col) || " ";

                                        if ( colspan > 1 || rowspan > 1 ) {
                                            colspan = colspan || 1;
                                            rowspan = rowspan || 1;
                                            r.push({colSpan: colspan, rowSpan: rowspan, text: cellValue});
                                        }
                                        else
                                            r.push(cellValue);
                                    }
                                    else
                                        r.push(" ");
                                });

                            if ( r.length )
                                body.push(r);

                            if ( rlength < r.length )
                                rlength = r.length;

                            rowIndex++;
                        });

                        return rlength;
                    };

                    $hrows = $(this).find('thead').first().find(defaults.theadSelector);

                    var colcount = CollectPdfmakeData($hrows, 'th,td', $hrows.length);

                    for ( var i = widths.length; i < colcount; i++ )
                        widths.push("*");

                    // Data
                    $rows = collectRows ($(this));

                    CollectPdfmakeData($rows, 'th,td', $hrows.length + $rows.length);

                    var docDefinition = {
                        content: [{
                            table: {
                                headerRows: $hrows.length,
                                widths:     widths,
                                body:       body
                            }
                        }]
                    };

                    $.extend(true, docDefinition, defaults.pdfmake.docDefinition);

                    pdfMake.fonts = {
                        Roboto: {
                            normal:      'Roboto-Regular.ttf',
                            bold:        'Roboto-Medium.ttf',
                            italics:     'Roboto-Italic.ttf',
                            bolditalics: 'Roboto-MediumItalic.ttf'
                        }
                    };

                    $.extend(true, pdfMake.fonts, defaults.pdfmake.fonts);

                    pdfMake.createPdf(docDefinition).getBuffer(function (buffer) {

                        try {
                            var blob = new Blob([buffer], {type: "application/pdf"});
                            saveAs(blob, defaults.fileName + '.pdf');
                        }
                        catch (e) {
                            downloadFile(defaults.fileName + '.pdf',
                                'data:application/pdf;base64,',
                                buffer);
                        }
                    });

                }
                else if ( defaults.jspdf.autotable === false ) {
                    // pdf output using jsPDF's core html support

                    var addHtmlOptions = {
                        dim:       {
                            w: getPropertyUnitValue($(el).first().get(0), 'width', 'mm'),
                            h: getPropertyUnitValue($(el).first().get(0), 'height', 'mm')
                        },
                        pagesplit: false
                    };

                    var doc = new jsPDF(defaults.jspdf.orientation, defaults.jspdf.unit, defaults.jspdf.format);
                    doc.addHTML($(el).first(),
                        defaults.jspdf.margins.left,
                        defaults.jspdf.margins.top,
                        addHtmlOptions,
                        function () {
                            jsPdfOutput(doc, false);
                        });
                    //delete doc;
                }
                else {
                    // pdf output using jsPDF AutoTable plugin
                    // https://github.com/simonbengtsson/jsPDF-AutoTable

                    var teOptions = defaults.jspdf.autotable.tableExport;

                    // When setting jspdf.format to 'bestfit' tableExport tries to choose
                    // the minimum required paper format and orientation in which the table
                    // (or tables in multitable mode) completely fits without column adjustment
                    if ( typeof defaults.jspdf.format === 'string' && defaults.jspdf.format.toLowerCase() === 'bestfit' ) {
                        var pageFormats = {
                            'a0': [2383.94, 3370.39], 'a1': [1683.78, 2383.94],
                            'a2': [1190.55, 1683.78], 'a3': [841.89, 1190.55],
                            'a4': [595.28, 841.89]
                        };
                        var rk = '', ro = '';
                        var mw = 0;

                        $(el).each(function () {
                            if ( isVisible($(this)) ) {
                                var w = getPropertyUnitValue($(this).get(0), 'width', 'pt');

                                if ( w > mw ) {
                                    if ( w > pageFormats.a0[0] ) {
                                        rk = 'a0';
                                        ro = 'l';
                                    }
                                    for ( var key in pageFormats ) {
                                        if ( pageFormats.hasOwnProperty(key) ) {
                                            if ( pageFormats[key][1] > w ) {
                                                rk = key;
                                                ro = 'l';
                                                if ( pageFormats[key][0] > w )
                                                    ro = 'p';
                                            }
                                        }
                                    }
                                    mw = w;
                                }
                            }
                        });
                        defaults.jspdf.format      = (rk === '' ? 'a4' : rk);
                        defaults.jspdf.orientation = (ro === '' ? 'w' : ro);
                    }

                    // The jsPDF doc object is stored in defaults.jspdf.autotable.tableExport,
                    // thus it can be accessed from any callback function
                    if ( teOptions.doc == null ) {
                        teOptions.doc = new jsPDF(defaults.jspdf.orientation,
                            defaults.jspdf.unit,
                            defaults.jspdf.format);

                        if ( typeof defaults.jspdf.onDocCreated === 'function' )
                            defaults.jspdf.onDocCreated(teOptions.doc);
                    }

                    if ( teOptions.outputImages === true )
                        teOptions.images = {};

                    if ( typeof teOptions.images != 'undefined' ) {
                        $(el).filter(function () {
                            return isVisible($(this));
                        }).each(function () {
                            var rowCount = 0;
                            ranges       = [];

                            if ( defaults.exportHiddenCells === false ) {
                                $hiddenTableElements = $(this).find("tr, th, td").filter(":hidden");
                                checkCellVisibilty = $hiddenTableElements.length > 0;
                            }

                            $hrows = $(this).find('thead').find(defaults.theadSelector);
                            $rows = collectRows ($(this));

                            $($rows).each(function () {
                                ForEachVisibleCell(this, 'td,th', $hrows.length + rowCount, $hrows.length + $rows.length,
                                    function (cell) {
                                        if ( typeof cell !== 'undefined' && cell !== null ) {
                                            var kids = $(cell).children();
                                            if ( typeof kids != 'undefined' && kids.length > 0 )
                                                collectImages(cell, kids, teOptions);
                                        }
                                    });
                                rowCount++;
                            });
                        });

                        $hrows = [];
                        $rows  = [];
                    }

                    loadImages(teOptions, function () {
                        $(el).filter(function () {
                            return isVisible($(this));
                        }).each(function () {
                            var colKey;
                            rowIndex = 0;
                            ranges   = [];

                            if ( defaults.exportHiddenCells === false ) {
                                $hiddenTableElements = $(this).find("tr, th, td").filter(":hidden");
                                checkCellVisibilty = $hiddenTableElements.length > 0;
                            }

                            colNames = GetColumnNames(this);

                            teOptions.columns    = [];
                            teOptions.rows       = [];
                            teOptions.rowoptions = {};

                            // onTable: optional callback function for every matching table that can be used
                            // to modify the tableExport options or to skip the output of a particular table
                            // if the table selector targets multiple tables
                            if ( typeof teOptions.onTable === 'function' )
                                if ( teOptions.onTable($(this), defaults) === false )
                                    return true; // continue to next iteration step (table)

                            // each table works with an own copy of AutoTable options
                            defaults.jspdf.autotable.tableExport = null;  // avoid deep recursion error
                            var atOptions                        = $.extend(true, {}, defaults.jspdf.autotable);
                            defaults.jspdf.autotable.tableExport = teOptions;

                            atOptions.margin = {};
                            $.extend(true, atOptions.margin, defaults.jspdf.margins);
                            atOptions.tableExport = teOptions;

                            // Fix jsPDF Autotable's row height calculation
                            if ( typeof atOptions.beforePageContent !== 'function' ) {
                                atOptions.beforePageContent = function (data) {
                                    if ( data.pageCount == 1 ) {
                                        var all = data.table.rows.concat(data.table.headerRow);
                                        all.forEach(function (row) {
                                            if ( row.height > 0 ) {
                                                row.height += (2 - FONT_ROW_RATIO) / 2 * row.styles.fontSize;
                                                data.table.height += (2 - FONT_ROW_RATIO) / 2 * row.styles.fontSize;
                                            }
                                        });
                                    }
                                };
                            }

                            if ( typeof atOptions.createdHeaderCell !== 'function' ) {
                                // apply some original css styles to pdf header cells
                                atOptions.createdHeaderCell = function (cell, data) {

                                    // jsPDF AutoTable plugin v2.0.14 fix: each cell needs its own styles object
                                    cell.styles = $.extend({}, data.row.styles);

                                    if ( typeof teOptions.columns [data.column.dataKey] != 'undefined' ) {
                                        var col = teOptions.columns [data.column.dataKey];

                                        if ( typeof col.rect != 'undefined' ) {
                                            var rh;

                                            cell.contentWidth = col.rect.width;

                                            if ( typeof teOptions.heightRatio == 'undefined' || teOptions.heightRatio === 0 ) {
                                                if ( data.row.raw [data.column.dataKey].rowspan )
                                                    rh = data.row.raw [data.column.dataKey].rect.height / data.row.raw [data.column.dataKey].rowspan;
                                                else
                                                    rh = data.row.raw [data.column.dataKey].rect.height;

                                                teOptions.heightRatio = cell.styles.rowHeight / rh;
                                            }

                                            rh = data.row.raw [data.column.dataKey].rect.height * teOptions.heightRatio;
                                            if ( rh > cell.styles.rowHeight )
                                                cell.styles.rowHeight = rh;
                                        }

                                        if ( typeof col.style != 'undefined' && col.style.hidden !== true ) {
                                            cell.styles.halign = col.style.align;
                                            if ( atOptions.styles.fillColor === 'inherit' )
                                                cell.styles.fillColor = col.style.bcolor;
                                            if ( atOptions.styles.textColor === 'inherit' )
                                                cell.styles.textColor = col.style.color;
                                            if ( atOptions.styles.fontStyle === 'inherit' )
                                                cell.styles.fontStyle = col.style.fstyle;
                                        }
                                    }
                                };
                            }

                            if ( typeof atOptions.createdCell !== 'function' ) {
                                // apply some original css styles to pdf table cells
                                atOptions.createdCell = function (cell, data) {
                                    var rowopt = teOptions.rowoptions [data.row.index + ":" + data.column.dataKey];

                                    if ( typeof rowopt != 'undefined' &&
                                        typeof rowopt.style != 'undefined' &&
                                        rowopt.style.hidden !== true ) {
                                        cell.styles.halign = rowopt.style.align;
                                        if ( atOptions.styles.fillColor === 'inherit' )
                                            cell.styles.fillColor = rowopt.style.bcolor;
                                        if ( atOptions.styles.textColor === 'inherit' )
                                            cell.styles.textColor = rowopt.style.color;
                                        if ( atOptions.styles.fontStyle === 'inherit' )
                                            cell.styles.fontStyle = rowopt.style.fstyle;
                                    }
                                };
                            }

                            if ( typeof atOptions.drawHeaderCell !== 'function' ) {
                                atOptions.drawHeaderCell = function (cell, data) {
                                    var colopt = teOptions.columns [data.column.dataKey];

                                    if ( (colopt.style.hasOwnProperty("hidden") !== true || colopt.style.hidden !== true) &&
                                        colopt.rowIndex >= 0 )
                                        return prepareAutoTableText(cell, data, colopt);
                                    else
                                        return false; // cell is hidden
                                };
                            }

                            if ( typeof atOptions.drawCell !== 'function' ) {
                                atOptions.drawCell = function (cell, data) {
                                    var rowopt = teOptions.rowoptions [data.row.index + ":" + data.column.dataKey];
                                    if ( prepareAutoTableText(cell, data, rowopt) ) {

                                        teOptions.doc.rect(cell.x, cell.y, cell.width, cell.height, cell.styles.fillStyle);

                                        if ( typeof rowopt != 'undefined' && typeof rowopt.kids != 'undefined' && rowopt.kids.length > 0 ) {

                                            var dh = cell.height / rowopt.rect.height;
                                            if ( dh > teOptions.dh || typeof teOptions.dh == 'undefined' )
                                                teOptions.dh = dh;
                                            teOptions.dw = cell.width / rowopt.rect.width;

                                            var y = cell.textPos.y;
                                            drawAutotableElements(cell, rowopt.kids, teOptions);
                                            cell.textPos.y = y;
                                            drawAutotableText(cell, rowopt.kids, teOptions);
                                        }
                                        else
                                            drawAutotableText(cell, {}, teOptions);
                                    }
                                    return false;
                                };
                            }

                            // collect header and data rows
                            teOptions.headerrows = [];
                            $hrows = $(this).find('thead').find(defaults.theadSelector);
                            $hrows.each(function () {
                                colKey = 0;
                                teOptions.headerrows[rowIndex] = [];

                                ForEachVisibleCell(this, 'th,td', rowIndex, $hrows.length,
                                    function (cell, row, col) {
                                        var obj      = getCellStyles(cell);
                                        obj.title    = parseString(cell, row, col);
                                        obj.key      = colKey++;
                                        obj.rowIndex = rowIndex;
                                        teOptions.headerrows[rowIndex].push(obj);
                                    });
                                rowIndex++;
                            });

                            if ( rowIndex > 0 ) {
                                // iterate through last row
                                var lastrow = rowIndex - 1;
                                while ( lastrow >= 0 ) {
                                    $.each(teOptions.headerrows[lastrow], function () {
                                        var obj = this;

                                        if ( lastrow > 0 && this.rect === null )
                                            obj = teOptions.headerrows[lastrow - 1][this.key];

                                        if ( obj !== null && obj.rowIndex >= 0 &&
                                            (obj.style.hasOwnProperty("hidden") !== true || obj.style.hidden !== true) )
                                            teOptions.columns.push(obj);
                                    });

                                    lastrow = (teOptions.columns.length > 0) ? -1 : lastrow - 1;
                                }
                            }

                            var rowCount = 0;
                            $rows        = [];
                            $rows = collectRows ($(this));
                            $($rows).each(function () {
                                var rowData = [];
                                colKey      = 0;

                                ForEachVisibleCell(this, 'td,th', rowIndex, $hrows.length + $rows.length,
                                    function (cell, row, col) {
                                        var obj;

                                        if ( typeof teOptions.columns[colKey] === 'undefined' ) {
                                            // jsPDF-Autotable needs columns. Thus define hidden ones for tables without thead
                                            obj = {
                                                title: '',
                                                key:   colKey,
                                                style: {
                                                    hidden: true
                                                }
                                            };
                                            teOptions.columns.push(obj);
                                        }
                                        if ( typeof cell !== 'undefined' && cell !== null ) {
                                            obj = getCellStyles(cell);
                                            obj.kids = $(cell).children();
                                            teOptions.rowoptions [rowCount + ":" + colKey++] = obj;
                                        }
                                        else {
                                            obj = $.extend(true, {}, teOptions.rowoptions [rowCount + ":" + (colKey - 1)]);
                                            obj.colspan = -1;
                                            teOptions.rowoptions [rowCount + ":" + colKey++] = obj;
                                        }

                                        rowData.push(parseString(cell, row, col));
                                    });
                                if ( rowData.length ) {
                                    teOptions.rows.push(rowData);
                                    rowCount++;
                                }
                                rowIndex++;
                            });

                            // onBeforeAutotable: optional callback function before calling
                            // jsPDF AutoTable that can be used to modify the AutoTable options
                            if ( typeof teOptions.onBeforeAutotable === 'function' )
                                teOptions.onBeforeAutotable($(this), teOptions.columns, teOptions.rows, atOptions);

                            teOptions.doc.autoTable(teOptions.columns, teOptions.rows, atOptions);

                            // onAfterAutotable: optional callback function after returning
                            // from jsPDF AutoTable that can be used to modify the AutoTable options
                            if ( typeof teOptions.onAfterAutotable === 'function' )
                                teOptions.onAfterAutotable($(this), atOptions);

                            // set the start position for the next table (in case there is one)
                            defaults.jspdf.autotable.startY = teOptions.doc.autoTableEndPosY() + atOptions.margin.top;

                        });

                        jsPdfOutput(teOptions.doc, (typeof teOptions.images != 'undefined' && jQuery.isEmptyObject(teOptions.images) === false));

                        if ( typeof teOptions.headerrows != 'undefined' )
                            teOptions.headerrows.length = 0;
                        if ( typeof teOptions.columns != 'undefined' )
                            teOptions.columns.length = 0;
                        if ( typeof teOptions.rows != 'undefined' )
                            teOptions.rows.length = 0;
                        delete teOptions.doc;
                        teOptions.doc = null;
                    });
                }
            }

            /*
            function FindColObject (objects, colIndex, rowIndex) {
              var result = null;
              $.each(objects, function () {
                if ( this.rowIndex == rowIndex && this.key == colIndex ) {
                  result = this;
                  return false;
                }
              });
              return result;
            }
            */
            function collectRows ($table) {
                var result = [];
                findTablePart($table,'tbody').each(function () {
                    result.push.apply(result, findRows($(this), defaults.tbodySelector));
                });
                if ( defaults.tfootSelector.length ) {
                    findTablePart($table,'tfoot').each(function () {
                        result.push.apply(result, findRows($(this), defaults.tfootSelector));
                    });
                }
                return result;
            }

            function findTablePart ($table, type) {
                var tl = $table.parents('table').length;
                return $table.find(type).filter (function () {
                    return $(this).closest('table').parents('table').length === tl;
                });
            }

            function findRows ($tpart, rowSelector) {
                return $tpart.find(rowSelector).filter (function () {
                    return $(this).find('table').length === 0 && $(this).parents('table').length === 1;
                });
            }

            function GetColumnNames (table) {
                var result = [];
                $(table).find('thead').first().find('th').each(function (index, el) {
                    if ( $(el).attr("data-field") !== undefined )
                        result[index] = $(el).attr("data-field");
                    else
                        result[index] = index.toString();
                });
                return result;
            }

            function isVisible ($element) {
                var isCell = typeof $element[0].cellIndex !== 'undefined';
                var isRow = typeof $element[0].rowIndex !== 'undefined';
                var isElementVisible = (isCell || isRow) ? isTableElementVisible($element) : $element.is(':visible');
                var tableexportDisplay = $element.data("tableexport-display");

                if (isCell && tableexportDisplay != 'none' && tableexportDisplay != 'always') {
                    $element = $($element[0].parentNode);
                    isRow = typeof $element[0].rowIndex !== 'undefined';
                    tableexportDisplay = $element.data("tableexport-display");
                }
                if (isRow && tableexportDisplay != 'none' && tableexportDisplay != 'always') {
                    tableexportDisplay = $element.closest('table').data("tableexport-display");
                }

                return tableexportDisplay !== 'none' && (isElementVisible == true || tableexportDisplay == 'always');
            }

            function isTableElementVisible ($element) {
                var hiddenEls = [];

                if ( checkCellVisibilty ) {
                    hiddenEls = $hiddenTableElements.filter (function () {
                        var found = false;

                        if (this.nodeType == $element[0].nodeType) {
                            if (typeof this.rowIndex !== 'undefined' && this.rowIndex == $element[0].rowIndex)
                                found = true;
                            else if (typeof this.cellIndex !== 'undefined' && this.cellIndex == $element[0].cellIndex &&
                                typeof this.parentNode.rowIndex !== 'undefined' &&
                                typeof $element[0].parentNode.rowIndex !== 'undefined' &&
                                this.parentNode.rowIndex == $element[0].parentNode.rowIndex)
                                found = true;
                        }
                        return found;
                    });
                }
                return (checkCellVisibilty == false || hiddenEls.length == 0);
            }

            function isColumnIgnored ($cell, rowLength, colIndex) {
                var result = false;

                if (isVisible($cell)) {
                    if ( defaults.ignoreColumn.length > 0 ) {
                        if ( $.inArray(colIndex, defaults.ignoreColumn) != -1 ||
                            $.inArray(colIndex - rowLength, defaults.ignoreColumn) != -1 ||
                            (colNames.length > colIndex && typeof colNames[colIndex] != 'undefined' &&
                                $.inArray(colNames[colIndex], defaults.ignoreColumn) != -1) )
                            result = true;
                    }
                }
                else
                    result = true;

                return result;
            }

            function ForEachVisibleCell (tableRow, selector, rowIndex, rowCount, cellcallback) {
                if ( typeof (cellcallback) === 'function' ) {
                    var ignoreRow = false;

                    if (typeof defaults.onIgnoreRow === 'function')
                        ignoreRow = defaults.onIgnoreRow($(tableRow), rowIndex);

                    if (ignoreRow === false &&
                        $.inArray(rowIndex, defaults.ignoreRow) == -1 &&
                        $.inArray(rowIndex - rowCount, defaults.ignoreRow) == -1 &&
                        isVisible($(tableRow))) {

                        var $cells = $(tableRow).find(selector);
                        var cellCount = 0;

                        $cells.each(function (colIndex) {
                            var $cell = $(this);
                            var c;
                            var colspan = parseInt(this.getAttribute('colspan'));
                            var rowspan = parseInt(this.getAttribute('rowspan'));

                            // Skip ranges
                            ranges.forEach(function (range) {
                                if ( rowIndex >= range.s.r && rowIndex <= range.e.r && cellCount >= range.s.c && cellCount <= range.e.c ) {
                                    for ( c = 0; c <= range.e.c - range.s.c; ++c )
                                        cellcallback(null, rowIndex, cellCount++);
                                }
                            });

                            if ( isColumnIgnored($cell, $cells.length, colIndex) === false ) {
                                // Handle Row Span
                                if ( rowspan || colspan ) {
                                    rowspan = rowspan || 1;
                                    colspan = colspan || 1;
                                    ranges.push({
                                        s: {r: rowIndex, c: cellCount},
                                        e: {r: rowIndex + rowspan - 1, c: cellCount + colspan - 1}
                                    });
                                }

                                // Handle Value
                                cellcallback(this, rowIndex, cellCount++);
                            }

                            // Handle Colspan
                            if ( colspan )
                                for ( c = 0; c < colspan - 1; ++c )
                                    cellcallback(null, rowIndex, cellCount++);
                        });

                        // Skip ranges
                        ranges.forEach(function (range) {
                            if ( rowIndex >= range.s.r && rowIndex <= range.e.r && cellCount >= range.s.c && cellCount <= range.e.c ) {
                                for ( c = 0; c <= range.e.c - range.s.c; ++c )
                                    cellcallback(null, rowIndex, cellCount++);
                            }
                        });
                    }
                }
            }

            function jsPdfOutput (doc, hasimages) {
                if ( defaults.consoleLog === true )
                    console.log(doc.output());

                if ( defaults.outputMode === 'string' )
                    return doc.output();

                if ( defaults.outputMode === 'base64' )
                    return base64encode(doc.output());

                if ( defaults.outputMode === 'window' ) {
                    window.URL = window.URL || window.webkitURL;
                    window.open(window.URL.createObjectURL(doc.output("blob")));
                    return;
                }

                try {
                    var blob = doc.output('blob');
                    saveAs(blob, defaults.fileName + '.pdf');
                }
                catch (e) {
                    downloadFile(defaults.fileName + '.pdf',
                        'data:application/pdf' + (hasimages ? '' : ';base64') + ',',
                        hasimages ? doc.output('blob') : doc.output());
                }
            }

            function prepareAutoTableText (cell, data, cellopt) {
                var cs = 0;
                if ( typeof cellopt !== 'undefined' )
                    cs = cellopt.colspan;

                if ( cs >= 0 ) {
                    // colspan handling
                    var cellWidth = cell.width;
                    var textPosX  = cell.textPos.x;
                    var i         = data.table.columns.indexOf(data.column);

                    for ( var c = 1; c < cs; c++ ) {
                        var column = data.table.columns[i + c];
                        cellWidth += column.width;
                    }

                    if ( cs > 1 ) {
                        if ( cell.styles.halign === 'right' )
                            textPosX = cell.textPos.x + cellWidth - cell.width;
                        else if ( cell.styles.halign === 'center' )
                            textPosX = cell.textPos.x + (cellWidth - cell.width) / 2;
                    }

                    cell.width     = cellWidth;
                    cell.textPos.x = textPosX;

                    if ( typeof cellopt !== 'undefined' && cellopt.rowspan > 1 )
                        cell.height = cell.height * cellopt.rowspan;

                    // fix jsPDF's calculation of text position
                    if ( cell.styles.valign === 'middle' || cell.styles.valign === 'bottom' ) {
                        var splittedText = typeof cell.text === 'string' ? cell.text.split(/\r\n|\r|\n/g) : cell.text;
                        var lineCount    = splittedText.length || 1;
                        if ( lineCount > 2 )
                            cell.textPos.y -= ((2 - FONT_ROW_RATIO) / 2 * data.row.styles.fontSize) * (lineCount - 2) / 3;
                    }
                    return true;
                }
                else
                    return false; // cell is hidden (colspan = -1), don't draw it
            }

            function collectImages (cell, elements, teOptions) {
                if ( typeof teOptions.images != 'undefined' ) {
                    elements.each(function () {
                        var kids = $(this).children();

                        if ( $(this).is("img") ) {
                            var hash = strHashCode(this.src);

                            teOptions.images[hash] = {
                                url: this.src,
                                src: this.src
                            };
                        }

                        if ( typeof kids != 'undefined' && kids.length > 0 )
                            collectImages(cell, kids, teOptions);
                    });
                }
            }

            function loadImages (teOptions, callback) {
                var i;
                var imageCount = 0;
                var x          = 0;

                function done () {
                    callback(imageCount);
                }

                function loadImage (image) {
                    if ( !image.url )
                        return;
                    var img         = new Image();
                    imageCount      = ++x;
                    img.crossOrigin = 'Anonymous';
                    img.onerror     = img.onload = function () {
                        if ( img.complete ) {

                            if ( img.src.indexOf('data:image/') === 0 ) {
                                img.width  = image.width || img.width || 0;
                                img.height = image.height || img.height || 0;
                            }

                            if ( img.width + img.height ) {
                                var canvas = document.createElement("canvas");
                                var ctx    = canvas.getContext("2d");

                                canvas.width  = img.width;
                                canvas.height = img.height;
                                ctx.drawImage(img, 0, 0);

                                image.src = canvas.toDataURL("image/jpeg");
                            }
                        }
                        if ( !--x )
                            done();
                    };
                    img.src = image.url;
                }

                if ( typeof teOptions.images != 'undefined' ) {
                    for ( i in teOptions.images )
                        if ( teOptions.images.hasOwnProperty(i) )
                            loadImage(teOptions.images[i]);
                }

                return x || done();
            }

            function drawAutotableElements (cell, elements, teOptions) {
                elements.each(function () {
                    var kids = $(this).children();
                    var uy   = 0;

                    if ( $(this).is("div") ) {
                        var bcolor = rgb2array(getStyle(this, 'background-color'), [255, 255, 255]);
                        var lcolor = rgb2array(getStyle(this, 'border-top-color'), [0, 0, 0]);
                        var lwidth = getPropertyUnitValue(this, 'border-top-width', defaults.jspdf.unit);

                        var r  = this.getBoundingClientRect();
                        var ux = this.offsetLeft * teOptions.dw;
                        uy = this.offsetTop * teOptions.dh;
                        var uw = r.width * teOptions.dw;
                        var uh = r.height * teOptions.dh;

                        teOptions.doc.setDrawColor.apply(undefined, lcolor);
                        teOptions.doc.setFillColor.apply(undefined, bcolor);
                        teOptions.doc.setLineWidth(lwidth);
                        teOptions.doc.rect(cell.x + ux, cell.y + uy, uw, uh, lwidth ? "FD" : "F");
                    }
                    else if ( $(this).is("img") ) {
                        if ( typeof teOptions.images != 'undefined' ) {
                            var hash  = strHashCode(this.src);
                            var image = teOptions.images[hash];

                            if ( typeof image != 'undefined' ) {

                                var arCell    = cell.width / cell.height;
                                var arImg     = this.width / this.height;
                                var imgWidth  = cell.width;
                                var imgHeight = cell.height;
                                var px2pt     = 0.264583 * 72 / 25.4;

                                if ( arImg <= arCell ) {
                                    imgHeight = Math.min(cell.height, this.height);
                                    imgWidth  = this.width * imgHeight / this.height;
                                }
                                else if ( arImg > arCell ) {
                                    imgWidth  = Math.min(cell.width, this.width);
                                    imgHeight = this.height * imgWidth / this.width;
                                }

                                imgWidth *= px2pt;
                                imgHeight *= px2pt;

                                if ( imgHeight < cell.height )
                                    uy = (cell.height - imgHeight) / 2;

                                try {
                                    teOptions.doc.addImage(image.src, cell.textPos.x, cell.y + uy, imgWidth, imgHeight);
                                }
                                catch (e) {
                                    // TODO: IE -> convert png to jpeg
                                }
                                cell.textPos.x += imgWidth;
                            }
                        }
                    }

                    if ( typeof kids != 'undefined' && kids.length > 0 )
                        drawAutotableElements(cell, kids, teOptions);
                });
            }

            function drawAutotableText (cell, texttags, teOptions) {
                if ( typeof teOptions.onAutotableText === 'function' ) {
                    teOptions.onAutotableText(teOptions.doc, cell, texttags);
                }
                else {
                    var x     = cell.textPos.x;
                    var y     = cell.textPos.y;
                    var style = {halign: cell.styles.halign, valign: cell.styles.valign};

                    if ( texttags.length ) {
                        var tag = texttags[0];
                        while ( tag.previousSibling )
                            tag = tag.previousSibling;

                        var b = false, i = false;

                        while ( tag ) {
                            var txt = tag.innerText || tag.textContent || "";

                            txt = ((txt.length && txt[0] == " ") ? " " : "") +
                                $.trim(txt) +
                                ((txt.length > 1 && txt[txt.length - 1] == " ") ? " " : "");

                            if ( $(tag).is("br") ) {
                                x = cell.textPos.x;
                                y += teOptions.doc.internal.getFontSize();
                            }

                            if ( $(tag).is("b") )
                                b = true;
                            else if ( $(tag).is("i") )
                                i = true;

                            if ( b || i )
                                teOptions.doc.setFontType((b && i) ? "bolditalic" : b ? "bold" : "italic");

                            var w = teOptions.doc.getStringUnitWidth(txt) * teOptions.doc.internal.getFontSize();

                            if ( w ) {
                                if ( cell.styles.overflow === 'linebreak' &&
                                    x > cell.textPos.x && (x + w) > (cell.textPos.x + cell.width) ) {
                                    var chars = ".,!%*;:=-";
                                    if ( chars.indexOf(txt.charAt(0)) >= 0 ) {
                                        var s = txt.charAt(0);
                                        w     = teOptions.doc.getStringUnitWidth(s) * teOptions.doc.internal.getFontSize();
                                        if ( (x + w) <= (cell.textPos.x + cell.width) ) {
                                            teOptions.doc.autoTableText(s, x, y, style);
                                            txt = txt.substring(1, txt.length);
                                        }
                                        w = teOptions.doc.getStringUnitWidth(txt) * teOptions.doc.internal.getFontSize();
                                    }
                                    x = cell.textPos.x;
                                    y += teOptions.doc.internal.getFontSize();
                                }

                                while ( txt.length && (x + w) > (cell.textPos.x + cell.width) ) {
                                    txt = txt.substring(0, txt.length - 1);
                                    w   = teOptions.doc.getStringUnitWidth(txt) * teOptions.doc.internal.getFontSize();
                                }

                                teOptions.doc.autoTableText(txt, x, y, style);
                                x += w;
                            }

                            if ( b || i ) {
                                if ( $(tag).is("b") )
                                    b = false;
                                else if ( $(tag).is("i") )
                                    i = false;

                                teOptions.doc.setFontType((!b && !i) ? "normal" : b ? "bold" : "italic");
                            }

                            tag = tag.nextSibling;
                        }
                        cell.textPos.x = x;
                        cell.textPos.y = y;
                    }
                    else {
                        teOptions.doc.autoTableText(cell.text, cell.textPos.x, cell.textPos.y, style);
                    }
                }
            }

            function escapeRegExp (string) {
                return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
            }

            function replaceAll (string, find, replace) {
                return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
            }

            function parseNumber (value) {
                value = value || "0";
                value = replaceAll(value, defaults.numbers.html.thousandsSeparator, '');
                value = replaceAll(value, defaults.numbers.html.decimalMark, '.');

                return typeof value === "number" || jQuery.isNumeric(value) !== false ? value : false;
            }

            function parsePercent (value) {
                if ( value.indexOf("%") > -1 ) {
                    value = parseNumber(value.replace(/%/g, ""));
                    if ( value !== false )
                        value = value / 100;
                }
                else
                    value = false;
                return value;
            }

            function parseString (cell, rowIndex, colIndex) {
                var result = '';

                if ( cell !== null ) {
                    var $cell = $(cell);
                    var htmlData;

                    if ( $cell[0].hasAttribute("data-tableexport-value") ) {
                        htmlData = $cell.data("tableexport-value");
                        htmlData = htmlData ? htmlData + '' : ''
                    }
                    else {
                        htmlData = $cell.html();

                        if ( typeof defaults.onCellHtmlData === 'function' )
                            htmlData = defaults.onCellHtmlData($cell, rowIndex, colIndex, htmlData);
                        else if ( htmlData != '' ) {
                            var html      = $.parseHTML(htmlData);
                            var inputidx  = 0;
                            var selectidx = 0;

                            htmlData = '';
                            $.each(html, function () {
                                if ( $(this).is("input") )
                                    htmlData += $cell.find('input').eq(inputidx++).val();
                                else if ( $(this).is("select") )
                                    htmlData += $cell.find('select option:selected').eq(selectidx++).text();
                                else {
                                    if ( typeof $(this).html() === 'undefined' )
                                        htmlData += $(this).text();
                                    else if ( jQuery().bootstrapTable === undefined ||
                                        ($(this).hasClass('filterControl') !== true &&
                                            $(cell).parents('.detail-view').length === 0) )
                                        htmlData += $(this).html();
                                }
                            });
                        }
                    }

                    if ( defaults.htmlContent === true ) {
                        result = $.trim(htmlData);
                    }
                    else if ( htmlData && htmlData != '' ) {
                        var cellFormat = $(cell).data("tableexport-cellformat");

                        if ( cellFormat != '' ) {
                            var text   = htmlData.replace(/\n/g, '\u2028').replace(/<br\s*[\/]?>/gi, '\u2060');
                            var obj    = $('<div/>').html(text).contents();
                            var number = false;
                            text       = '';
                            $.each(obj.text().split("\u2028"), function (i, v) {
                                if ( i > 0 )
                                    text += " ";
                                text += $.trim(v);
                            });

                            $.each(text.split("\u2060"), function (i, v) {
                                if ( i > 0 )
                                    result += "\n";
                                result += $.trim(v).replace(/\u00AD/g, ""); // remove soft hyphens
                            });

                            if ( defaults.type == 'json' ||
                                (defaults.type === 'excel' && defaults.excelFileFormat === 'xmlss') ||
                                defaults.numbers.output === false ) {
                                number = parseNumber(result);

                                if ( number !== false )
                                    result = Number(number);
                            }
                            else if ( defaults.numbers.html.decimalMark != defaults.numbers.output.decimalMark ||
                                defaults.numbers.html.thousandsSeparator != defaults.numbers.output.thousandsSeparator ) {
                                number = parseNumber(result);

                                if ( number !== false ) {
                                    var frac = ("" + number.substr(number < 0 ? 1 : 0)).split('.');
                                    if ( frac.length == 1 )
                                        frac[1] = "";
                                    var mod = frac[0].length > 3 ? frac[0].length % 3 : 0;

                                    result = (number < 0 ? "-" : "") +
                                        (defaults.numbers.output.thousandsSeparator ? ((mod ? frac[0].substr(0, mod) + defaults.numbers.output.thousandsSeparator : "") + frac[0].substr(mod).replace(/(\d{3})(?=\d)/g, "$1" + defaults.numbers.output.thousandsSeparator)) : frac[0]) +
                                        (frac[1].length ? defaults.numbers.output.decimalMark + frac[1] : "");
                                }
                            }
                        }
                        else
                            result = htmlData;
                    }

                    if ( defaults.escape === true ) {
                        //noinspection JSDeprecatedSymbols
                        result = escape(result);
                    }

                    if ( typeof defaults.onCellData === 'function' ) {
                        result = defaults.onCellData($cell, rowIndex, colIndex, result);
                    }
                }

                return result;
            }

            //noinspection JSUnusedLocalSymbols
            function hyphenate (a, b, c) {
                return b + "-" + c.toLowerCase();
            }

            function rgb2array (rgb_string, default_result) {
                var re     = /^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/;
                var bits   = re.exec(rgb_string);
                var result = default_result;
                if ( bits )
                    result = [parseInt(bits[1]), parseInt(bits[2]), parseInt(bits[3])];
                return result;
            }

            function getCellStyles (cell) {
                var a  = getStyle(cell, 'text-align');
                var fw = getStyle(cell, 'font-weight');
                var fs = getStyle(cell, 'font-style');
                var f  = '';
                if ( a == 'start' )
                    a = getStyle(cell, 'direction') == 'rtl' ? 'right' : 'left';
                if ( fw >= 700 )
                    f = 'bold';
                if ( fs == 'italic' )
                    f += fs;
                if ( f === '' )
                    f = 'normal';

                var result = {
                    style:   {
                        align:  a,
                        bcolor: rgb2array(getStyle(cell, 'background-color'), [255, 255, 255]),
                        color:  rgb2array(getStyle(cell, 'color'), [0, 0, 0]),
                        fstyle: f
                    },
                    colspan: (parseInt($(cell).attr('colspan')) || 0),
                    rowspan: (parseInt($(cell).attr('rowspan')) || 0)
                };

                if ( cell !== null ) {
                    var r       = cell.getBoundingClientRect();
                    result.rect = {
                        width:  r.width,
                        height: r.height
                    };
                }

                return result;
            }

            // get computed style property
            function getStyle (target, prop) {
                try {
                    if ( window.getComputedStyle ) { // gecko and webkit
                        prop = prop.replace(/([a-z])([A-Z])/, hyphenate);  // requires hyphenated, not camel
                        return window.getComputedStyle(target, null).getPropertyValue(prop);
                    }
                    if ( target.currentStyle ) { // ie
                        return target.currentStyle[prop];
                    }
                    return target.style[prop];
                }
                catch (e) {
                }
                return "";
            }

            function getUnitValue (parent, value, unit) {
                var baseline = 100;  // any number serves

                var temp              = document.createElement("div");  // create temporary element
                temp.style.overflow   = "hidden";  // in case baseline is set too low
                temp.style.visibility = "hidden";  // no need to show it

                parent.appendChild(temp); // insert it into the parent for em, ex and %

                temp.style.width = baseline + unit;
                var factor       = baseline / temp.offsetWidth;

                parent.removeChild(temp);  // clean up

                return (value * factor);
            }

            function getPropertyUnitValue (target, prop, unit) {
                var value = getStyle(target, prop);  // get the computed style value

                var numeric = value.match(/\d+/);  // get the numeric component
                if ( numeric !== null ) {
                    numeric = numeric[0];  // get the string

                    return getUnitValue(target.parentElement, numeric, unit);
                }
                return 0;
            }

            function jx_Workbook () {
                if ( !(this instanceof jx_Workbook) ) {
                    //noinspection JSPotentiallyInvalidConstructorUsage
                    return new jx_Workbook();
                }
                this.SheetNames = [];
                this.Sheets     = {};
            }

            function jx_s2ab (s) {
                var buf  = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for ( var i = 0; i != s.length; ++i ) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
            }

            function jx_datenum (v, date1904) {
                if ( date1904 ) v += 1462;
                var epoch = Date.parse(v);
                return (epoch - new Date(Date.UTC(1899, 11, 30))) / (24 * 60 * 60 * 1000);
            }

            function jx_createSheet (data) {
                var ws    = {};
                var range = {s: {c: 10000000, r: 10000000}, e: {c: 0, r: 0}};
                for ( var R = 0; R != data.length; ++R ) {
                    for ( var C = 0; C != data[R].length; ++C ) {
                        if ( range.s.r > R ) range.s.r = R;
                        if ( range.s.c > C ) range.s.c = C;
                        if ( range.e.r < R ) range.e.r = R;
                        if ( range.e.c < C ) range.e.c = C;
                        var cell = {v: data[R][C]};
                        if ( cell.v === null ) continue;
                        var cell_ref = XLSX.utils.encode_cell({c: C, r: R});

                        if ( typeof cell.v === 'number' ) cell.t = 'n';
                        else if ( typeof cell.v === 'boolean' ) cell.t = 'b';
                        else if ( cell.v instanceof Date ) {
                            cell.t = 'n';
                            cell.z = XLSX.SSF._table[14];
                            cell.v = jx_datenum(cell.v);
                        }
                        else cell.t = 's';
                        ws[cell_ref] = cell;
                    }
                }

                if ( range.s.c < 10000000 ) ws['!ref'] = XLSX.utils.encode_range(range);
                return ws;
            }

            function strHashCode (str) {
                var hash = 0, i, chr, len;
                if ( str.length === 0 ) return hash;
                for ( i = 0, len = str.length; i < len; i++ ) {
                    chr  = str.charCodeAt(i);
                    hash = ((hash << 5) - hash) + chr;
                    hash |= 0; // Convert to 32bit integer
                }
                return hash;
            }

            function downloadFile (filename, header, data) {
                var ua = window.navigator.userAgent;
                if ( filename !== false && window.navigator.msSaveOrOpenBlob ) {
                    //noinspection JSUnresolvedFunction
                    window.navigator.msSaveOrOpenBlob(new Blob([data]), filename);
                }
                else if ( filename !== false && (ua.indexOf("MSIE ") > 0 || !!ua.match(/Trident.*rv\:11\./)) ) {
                    // Internet Explorer (<= 9) workaround by Darryl (https://github.com/dawiong/tableExport.jquery.plugin)
                    // based on sampopes answer on http://stackoverflow.com/questions/22317951
                    // ! Not working for json and pdf format !
                    var frame = document.createElement("iframe");

                    if ( frame ) {
                        document.body.appendChild(frame);
                        frame.setAttribute("style", "display:none");
                        frame.contentDocument.open("txt/html", "replace");
                        frame.contentDocument.write(data);
                        frame.contentDocument.close();
                        frame.focus();

                        frame.contentDocument.execCommand("SaveAs", true, filename);
                        document.body.removeChild(frame);
                    }
                }
                else {
                    var DownloadLink = document.createElement('a');

                    if ( DownloadLink ) {
                        var blobUrl = null;

                        DownloadLink.style.display = 'none';
                        if ( filename !== false )
                            DownloadLink.download = filename;
                        else
                            DownloadLink.target = '_blank';

                        if ( typeof data == 'object' ) {
                            window.URL = window.URL || window.webkitURL;
                            blobUrl = window.URL.createObjectURL(data);
                            DownloadLink.href = blobUrl;
                        }
                        else if ( header.toLowerCase().indexOf("base64,") >= 0 )
                            DownloadLink.href = header + base64encode(data);
                        else
                            DownloadLink.href = header + encodeURIComponent(data);

                        document.body.appendChild(DownloadLink);

                        if ( document.createEvent ) {
                            if ( DownloadEvt === null )
                                DownloadEvt = document.createEvent('MouseEvents');

                            DownloadEvt.initEvent('click', true, false);
                            DownloadLink.dispatchEvent(DownloadEvt);
                        }
                        else if ( document.createEventObject )
                            DownloadLink.fireEvent('onclick');
                        else if ( typeof DownloadLink.onclick == 'function' )
                            DownloadLink.onclick();

                        setTimeout(function(){
                            if ( blobUrl )
                                window.URL.revokeObjectURL(blobUrl);
                            document.body.removeChild(DownloadLink);
                        }, 100);
                    }
                }
            }

            function utf8Encode (text) {
                if (typeof text === 'string') {
                    text = text.replace(/\x0d\x0a/g, "\x0a");
                    var utftext = "";
                    for ( var n = 0; n < text.length; n++ ) {
                        var c = text.charCodeAt(n);
                        if ( c < 128 ) {
                            utftext += String.fromCharCode(c);
                        }
                        else if ( (c > 127) && (c < 2048) ) {
                            utftext += String.fromCharCode((c >> 6) | 192);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }
                        else {
                            utftext += String.fromCharCode((c >> 12) | 224);
                            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }
                    }
                    return utftext;
                }
                return text;
            }

            function base64encode (input) {
                var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
                var output = "";
                var i      = 0;
                input      = utf8Encode(input);
                while ( i < input.length ) {
                    chr1 = input.charCodeAt(i++);
                    chr2 = input.charCodeAt(i++);
                    chr3 = input.charCodeAt(i++);
                    enc1 = chr1 >> 2;
                    enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                    enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                    enc4 = chr3 & 63;
                    if ( isNaN(chr2) ) {
                        enc3 = enc4 = 64;
                    } else if ( isNaN(chr3) ) {
                        enc4 = 64;
                    }
                    output = output +
                        keyStr.charAt(enc1) + keyStr.charAt(enc2) +
                        keyStr.charAt(enc3) + keyStr.charAt(enc4);
                }
                return output;
            }

            return this;
        }
    });
})(jQuery);
