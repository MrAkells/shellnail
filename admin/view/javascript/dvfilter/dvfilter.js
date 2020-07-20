var dvfilter = {
    /**
     URL GET Variables
     **/
    url: {},
    /**
     PHP Data (languages, filter params..)
     **/
    php: {},
    /**
     Initialization
     **/
    init: function () {
        this.helper.setURLVars();

        /* DVFilter option values switcher */
        $(document).on('click', '.switcher .selected', function (e) {
            var $this = $(this).parent('.switcher');

            if (!$this.hasClass('active')) {
                $('.switcher').removeClass('active');
                $this.addClass('active');
            } else {
                $this.removeClass('active');
            }
        });

        $(document).on('change', '.switcher input[type=\'checkbox\']', function () {
            var $this = $(this), selected = $this.parents('.switcher').find('.selected'),
                text = $this.parent('label').text(), length = selected.find('span').length,
                counter = selected.find('strong').length;

            if (counter) {
                selected.find('strong').text($this.parents('.switcher').find('.values input[name*=\'[options_id][]\']:checked').length);
            } else {
                if ($this.prop('checked')) {
                    selected.append('<span id="v-' + this.value + '">' + text + '</span>').find('b').remove();

                    /*** Change for limit max input vars ***/
                        $this.parent().parent().find('input[type="text"]').removeAttr('disabled');
                    /*** *** ***/
                } else {
                    if (length === 1) {
                        $('#v-' + this.value).replaceWith('<b>' + dvfilter.php.text_select + '</b>');
                    } else {
                        $('#v-' + this.value).remove();
                    }
                    /*** Change for limit max input vars ***/
                        $this.parent().parent().find('input[type="text"]').attr('disabled', 'disabled');
                    /*** *** ***/
                }
            }
        });

        $(document).click(function (e) {
            if (!$(e.target).parents('.switcher').length) $('.switcher.active').removeClass('active');
            if (!$(e.target).parents('#colorbox').length) {
                $('#colorbox').remove();
                $('a.color-handler').removeClass('active');
            }
        });

        /* Floating Actions list */
        var actions = $('#list-actions'), scrolled = false, timeout = null;

        $(window).on('scroll', function () {
            if (window.pageYOffset > 35 && !scrolled) {
                scrolled = true;

                actions.addClass('scrolled');
            } else if (window.pageYOffset < 35 && scrolled) {
                scrolled = false;

                actions.removeClass('scrolled');
            }
        });

        $('.list input[name*=\'selected\'], .list thead input:first').on('change', function () {
            clearTimeout(timeout);

            actions.addClass('change');

            timeout = setTimeout(function () {
                actions.removeClass('change');
            }, 230);

            $('strong > span', actions).text($('input[name*=\'selected\']:checked').length);
        });

        /* Subfields */

        $('.with-subfield').on('change', function (e) {
            var $this = $(this), tag = e.target.nodeName.toLowerCase(), subfield = $this.attr('data-subfield');

            if (tag == 'input') {
                if (this.checked) {
                    $('.sf-' + subfield).addClass('visible');
                } else {
                    $('.sf-' + subfield).removeClass('visible');
                }
            } else if (tag == 'select') {
                $('.' + subfield).removeClass('visible');

                if (this.value) {
                    $('.sf-' + this.value.replace(/\_/g, '-')).addClass('visible');
                }
            }
        });
    },
    /**
     DVFilter List
     **/
    list: {
        init: function () {
            $('tr.filter input').keydown(function (e) {
                if (e.keyCode == 13) dvfilter.list.filter();
            });

            $('table input.edit, table select.edit').on('change', function () {
                var e = $(this), type = e.attr('type'), post = {
                    field: encodeURIComponent(e.attr('name')),
                    value: (type == 'checkbox' ? (this.checked ? 1 : 0) : encodeURIComponent(this.value)),
                    option_id: e.attr('for')
                };

                e.fadeTo(250, .3);

                $.post('index.php?route=catalog/dvfilter/edit&token=' + dvfilter.url['token'], post, function (json) {
                    if (json['status'] === true) {
                        e.fadeTo(250, 1).css('border', '1px solid #4BB349');

                        if (type == 'checkbox') {
                            var span = e.next('span');

                            span.text(span.text() == dvfilter.php.text_enabled ? dvfilter.php.text_disabled : dvfilter.php.text_enabled);
                        }
                    } else {
                        e.fadeTo(250, 1).css('border', '1px solid #E2302F');
                    }
                }, 'json');
            });
        },
        filter: function () {
            var $this = dvfilter, url = 'index.php?route=catalog/dvfilter&token=' + $this.url['token'], params = {};

            for (var i = 0; i < $this.php.filter_get.length; i++) {
                var key = $this.php.filter_get[i];

                params[key] = $('[name=\'' + key + '\']').val();

                if (params[key] != '') {
                    url += '&' + key + '=' + encodeURIComponent(params[key]);
                }
            }

            window.location = url;
        }
    },
    /**
     DVFilter Form
     **/
    form: {
        init: function () {
            /* Color picker by SooR. 12-07-2013 */

            var colorbox = [],
                colors = ['f00', 'ff0', '0f0', '0ff', '00f', 'f0f', 'fff', 'ebebeb', 'e1e1e1', 'd7d7d7', 'cccccc', 'c2c2c2', 'b7b7b7', 'acacac', 'a0a0a0', '959595', 'ee1d24', 'fff100', '00a650', '00aeef', '2f3192', 'ed008c', '898989', '7d7d7d', '707070', '626262', '555', '464646', '363636', '262626', '111', '000', 'f7977a', 'fbad82', 'fdc68c', 'fff799', 'c6df9c', 'a4d49d', '81ca9d', '7bcdc9', '6ccff7', '7ca6d8', '8293ca', '8881be', 'a286bd', 'bc8cbf', 'f49bc1', 'f5999d', 'f16c4d', 'f68e54', 'fbaf5a', 'fff467', 'acd372', '7dc473', '39b778', '16bcb4', '00bff3', '438ccb', '5573b7', '5e5ca7', '855fa8', 'a763a9', 'ef6ea8', 'f16d7e', 'ee1d24', 'f16522', 'f7941d', 'fff100', '8fc63d', '37b44a', '00a650', '00a99e', '00aeef', '0072bc', '0054a5', '2f3192', '652c91', '91278f', 'ed008c', 'ee105a', '9d0a0f', 'a1410d', 'a36209', 'aba000', '588528', '197b30', '007236', '00736a', '0076a4', '004a80', '003370', '1d1363', '450e61', '62055f', '9e005c', '9d0039', '790000', '7b3000', '7c4900', '827a00', '3e6617', '045f20', '005824', '005951', '005b7e', '003562', '002056', '0c004b', '30004a', '4b0048', '7a0045', '7a0026'];

            colorbox.push('<div id="colorbox">');

            for (var i = 0; i < colors.length; i++) {
                colorbox.push('<a href="#' + colors[i] + '" style="background-color: #' + colors[i] + ';"><i style="background-color: #' + colors[i] + ';"></i></a>');
            }

            colorbox.push('</div>');

            colorbox = colorbox.join('');

            $(document).on('click', 'a.color-handler', function () {
                $('#colorbox').remove();
                $('a.color-handler').not(this).removeClass('active');

                var $this = $(this);

                $this.toggleClass('active');

                if ($this.hasClass('active')) {
                    $this.after(colorbox);
                }

                return false;
            });

            $(document).on('click', '#colorbox a', function () {
                var $this = $(this), color = $this.attr('href').substr(1), value = $this.parents('li');

                value.find('input[name*=\'[color]\']').val(color);
                value.find('.color-handler').css('background', '#' + color);

                return false;
            });

            $(document).on('click', 'a.image-handler', function () {
                var $this = $(this), field = $this.parents('li').find('input[name*=\'[image]\']'),
                    index = $this.parents('li').index();

                if ($this.hasClass('inserted')) {
                    $('a.image-handler').removeClass('active');

                    field.val('').removeAttr('id');

                    $this.removeClass('inserted').html('<img src="view/image/banner.png" alt="" />');
                } else {
                    $('a.image-handler').not(this).removeClass('active');

                    $this.toggleClass('active');

                    if ($this.hasClass('active')) {
                        field.attr('id', 'image-' + index);

                        dvfilter.form.imageUpload($this, 'image-' + index);
                    }
                }

                return false;
            });

            /* Search category by SooR. UPD 12-07-2013 */
            $.expr[':'].icontains = function (a, i, m) {
                return $(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };

            var categories = $('#categories'), categoriesOffsetTop = categories.offset().top,
                categoriesHeight = categories.outerHeight();

            $('input[name=\'search\']').keyup(function () {
                categories.scrollTop(0).find('label').removeAttr('style');

                if (this.value) {
                    var find = categories.find('label:icontains(\'' + this.value + '\')');

                    if (find.length) {
                        find.css({'color': 'red', 'font-weight': 'bold'});

                        categories.scrollTop(find.offset().top - categoriesOffsetTop - categoriesHeight / 2);
                    }
                }
            });

            /* Numeric values clone for another name fields */
            if (dvfilter.php.languages.length > 1) {
                $(document).on('keyup', '.value-name', function () {
                    var $this = $(this), fields = $this.parents('.fields').find('input[name*=\'[name]\']').not(this),
                        text = this.value, numeric = /^\d/g.test(text);

                    if (numeric) fields.val(text);
                });
            }

            $(document).on('change', 'input[name=\'color\']', function () {
                if (this.checked) {
                    $('a.color-handler').addClass('visible');
                } else {
                    $('a.color-handler.visible').removeClass('visible');
                }

                dvfilter.php.color = this.checked;
            });

            $(document).on('change', 'input[name=\'image\']', function () {
                if (this.checked) {
                    $('a.image-handler').addClass('visible');
                } else {
                    $('a.image-handler.visible').removeClass('visible');
                }

                dvfilter.php.image = this.checked;
            });
        },

        valueRow: $('#sortable li').length,

        deleteValue: function (value) {
            value.parent('li').remove();

            this.valueRow--;
        },

        addValue: function () {
            var html = [];

            html.push('<li>');
            html.push('	<a class="delete" onclick="dvfilter.form.deleteValue($(this));">Delete</a>');
            html.push('	<div class="fields">');
            html.push('		<input type="hidden" name="dvfilter_option_value[insert][' + this.valueRow + '][color]" value="" />');
            html.push('		<input type="hidden" name="dvfilter_option_value[insert][' + this.valueRow + '][image]" value="" />');
            html.push('		<input type="hidden" name="dvfilter_option_value[insert][' + this.valueRow + '][sort_order]" value="' + this.valueRow + '" />');

            for (var i = 0; i < dvfilter.php.languages.length; i++) {
                var language = dvfilter.php.languages[i];

                html.push('	<label><input type="text" class="value-name" name="dvfilter_option_value[insert][' + this.valueRow + '][language][' + language.language_id + '][name]" value="" size="80" placeholder="Значение опции #' + this.valueRow + '" />&nbsp;<img src="view/image/flags/' + language.image + '" title="' + language.name + '" /></label>');
            }

            html.push('	</div>');
            html.push('	<a href="#" class="color-handler' + (dvfilter.php.color ? ' visible' : '') + '" title="' + dvfilter.php.text_select_color + '"></a>');
            html.push('	<a href="#" class="image-handler' + (dvfilter.php.image ? ' visible' : '') + '" title="' + dvfilter.php.text_browse_image + '"><img src="view/image/banner.png" alt="" /></a>');
            html.push('</li>');

            $('#sortable').append(html.join(''));

            this.valueRow++;
        },
        imageUpload: function (target, field) {
            $('#dialog').remove();

            $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=' + dvfilter.url['token'] + '&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

            $('#dialog').dialog({
                title: dvfilter.php.text_image_manager,
                close: function (event, ui) {
                    if ($('#' + field).attr('value')) {
                        $.ajax({
                            url: 'index.php?route=common/filemanager/image&token=' + dvfilter.url['token'] + '&image=' + encodeURIComponent($('#' + field).val()),
                            dataType: 'text',
                            success: function (data) {
                                target.addClass('inserted').html('<img src="' + data + '" alt="" />');
                            }
                        });
                    }

                    $('a.image-handler').removeClass('active');
                },
                bgiframe: false,
                width: 800,
                height: 400,
                resizable: false,
                modal: false
            });
        }
    },
    /**
     DVFilter Setting Form
     **/
    setting: {
        init: function () {
            $('input[type=\'checkbox\']').change(function () {
                $(this).parent('label').toggleClass('checked');
            });

            $('tr.install-package input').on('click', function () {
                $(this).select();
            });

            $('input[name=\'package[]\']').on('change', function () {
                if (this.checked) {
                    $('tr.install-package.package-' + this.value).show();
                } else {
                    $('tr.install-package.package-' + this.value).hide();
                }
            });

            $('#copy-attributes').on('click', function () {
                var $this = $(this), post = $('#tab-copy input:checked, #tab-copy select');

                $this.removeAttr('id').find('span').text(dvfilter.php.executed);

                $.post('index.php?route=module/dvfilter/copyAttributes&token=' + dvfilter.url['token'], post, function (json) {
                    if (json['message']) {
                        $('span', $this).text(json['message']);
                    }

                    setTimeout(function () {
                        $this.attr('id', 'copy-attributes').find('span').text(dvfilter.php.copy);
                    }, 3000);
                }, 'json');
            });

            $('#form').submit(function () {
                $(this).attr('action', $(this).attr('action') + window.location.hash);
            });
        }
    },
    /**
     DVFilter Product Form
     **/
    productForm: {
        category_id: null,
        product_id: null,
        length: null,
        init: function () {
            $('a[href=\'#tab-links\']').parent('li').after('<li><a href="#tab-dvfilter" data-toggle="tab">' + dvfilter.php.tab_dvfilter + '</a></li>');
            $('#tab-links').after('<div class="tab-pane" id="tab-dvfilter"><h2>' + dvfilter.php.dvfilter_select_category + '</h2></div>');

            $('a[href=\'#tab-general\']').tab('show');

            if (undefined !== dvfilter.url['product_id']) {
                this.product_id = dvfilter.url['product_id'];
            }

            this.length = $('#product-category div, input[type=\'checkbox\'][name=\'product_category[]\']:checked').length;

            setInterval(function () {
                var length = $('#product-category div, input[type=\'checkbox\'][name=\'product_category[]\']:checked').length;

                if (dvfilter.productForm.length != length) {
                    dvfilter.productForm.length = length;

                    dvfilter.productForm.update();
                }
            }, 500);

            this.update();
        },
        update: function () {
            if ($('input[type=\'checkbox\'][name=\'product_category[]\']:checked:last').length > 0) {
                this.category_id = $('input[name=\'product_category[]\']:checked:last').val();
            } else if ($('input[type=\'hidden\'][name=\'product_category[]\']:last').length > 0) {
                this.category_id = $('input[name=\'product_category[]\']:last').val();
            }

            var html = [], get = {
                token: dvfilter.url['token'],
                category_id: this.category_id
            };

            if (this.product_id) {
                get.product_id = this.product_id;
            }

            if (!get.category_id) {
                $('#tab-dvfilter').html('<h2>' + dvfilter.php.dvfilter_select_category + '</h2>');

                return;
            }

            $.get('index.php?route=catalog/dvfilter/callback', get, function (json) {
                if (json.message) {
                    $('#tab-dvfilter').html('<h2>' + json.message + '</h2>');

                    return;
                }

                html.push('<table class="form product-dvfilter-values">');

                for (var i = 0; i < json.options.length; i++) {
                    var option = json.options[i], values = [], selecteds = [];

                    html.push('<tr' + (!option.status ? ' class="disabled"' : '') + '>');
                    html.push('<td width="20%">' + option.name + '</td><td width="80%">');

                    if (option.type == 'slide' || option.type == 'slide_dual') {
                        html.push('<input type="hidden" name="dvfilter_product_option[' + option.option_id + '][values][0][selected]" value="1" />');
                        html.push('<input type="text" name="dvfilter_product_option[' + option.option_id + '][values][0][slide_value_min]" value="' + option.slide_value_min + '" size="5" class="slide-value-min" />&nbsp;&mdash;&nbsp;<input type="text" name="dvfilter_product_option[' + option.option_id + '][values][0][slide_value_max]" value="' + option.slide_value_max + '" size="5" class="slide-value-max" />' + option.postfix + '');

                        for (var l = 0; l < dvfilter.php.languages.length; l++) {
                            html.push('&nbsp;<input type="text" name="dvfilter_product_option[' + option.option_id + '][values][0][description][' + dvfilter.php.languages[l].language_id + '][description]" value="' + option.description[dvfilter.php.languages[l].language_id].description + '" size="30" class="description" style="background-image: url(\'view/image/flags/' + dvfilter.php.languages[l].image + '\');" />');
                        }
                    } else if (option.type == 'text') {
                        html.push('<input type="hidden" name="dvfilter_product_option[' + option.option_id + '][values][0][selected]" value="1" />');

                        for (var l = 0; l < dvfilter.php.languages.length; l++) {
                            html.push('<textarea name="dvfilter_product_option[' + option.option_id + '][values][0][description][' + dvfilter.php.languages[l].language_id + '][description]" rows="2" cols="40">' + option.description[dvfilter.php.languages[l].language_id].description + '</textarea>&nbsp;<img src="view/image/flags/' + dvfilter.php.languages[l].image + '" alt="' + dvfilter.php.languages[l].name + '" title="' + dvfilter.php.languages[l].name + '" /><br />');
                        }
                    } else {
                        if (option.values) {
                            for (var j in option.values) {
                                var value = option.values[j];

                                if (value.selected) {
                                    selecteds.push('<span id="v-' + value.value_id + '">' + value.name + option.postfix + '</span>');
                                }

                                values.push('<div>');

                                values.push(' <label><input type="checkbox" name="dvfilter_product_option[' + option.option_id + '][values][' + value.value_id + '][selected]" value="' + value.value_id + '"' + (value.selected ? ' checked="checked"' : '') + ' />' + value.name + option.postfix + '</label>');

                                /*** Change for limit max input vars ***/
                                if (value.selected) {
                                    for (var l = 0; l < dvfilter.php.languages.length; l++) {
                                        values.push('&nbsp;<input type="text" name="dvfilter_product_option[' + option.option_id + '][values][' + value.value_id + '][description][' + dvfilter.php.languages[l].language_id + '][description]" value="' + value.description[dvfilter.php.languages[l].language_id].description + '" size="30" style="background-image: url(\'view/image/flags/' + dvfilter.php.languages[l].image + '\');" />');
                                    }
                                } else {
                                    for (var l = 0; l < dvfilter.php.languages.length; l++) {
                                        values.push('&nbsp;<input type="text" name="dvfilter_product_option[' + option.option_id + '][values][' + value.value_id + '][description][' + dvfilter.php.languages[l].language_id + '][description]" value="' + value.description[dvfilter.php.languages[l].language_id].description + '" size="30" style="background-image: url(\'view/image/flags/' + dvfilter.php.languages[l].image + '\');" disabled="disabled" />');
                                    }
                                }
                                /*** *** ***/

                                values.push('</div>');
                            }

                            if (!selecteds.length) selecteds = ['<b>' + dvfilter.php.text_select + '</b>'];

                            html.push('<div class="switcher"><div class="selected">' + selecteds.join('') + '</div><div class="values">' + values.join('') + '</div>');
                        } else {
                            html.push('<a href="index.php?route=catalog/dvfilter/update&token=' + dvfilter.url['token'] + '&option_id=' + option.option_id + '" target="_blank">' + dvfilter.php.entry_values + '</a>');
                        }
                    }

                    html.push('</td></tr>');
                }

                html.push('</table>');

                $('#tab-dvfilter').html(html.join(''));
            }, 'json');
        }
    },
    /**
     Helpers
     **/
    helper: {
        setURLVars: function () {
            var vars = window.location.href.replace(window.location.hash, '').split('?')[1].split('&'),
                $this = dvfilter;

            for (var i = 0; i < vars.length; i++) {
                var parts = vars[i].split('=');

                dvfilter.url[parts[0]] = parts[1];
            }
        }
    }
};

$(function () {
    dvfilter.init();

    /**
     DVFilter List
     **/
    if (dvfilter.url['route'] == 'catalog/dvfilter') {
        dvfilter.list.init();
    }

    /**
     DVFilter Form
     **/
    if (dvfilter.url['route'] == 'catalog/dvfilter/insert' || dvfilter.url['route'] == 'catalog/dvfilter/update') {
        dvfilter.form.init();
    }

    /**
     DVFilter Product Form
     **/
    if (dvfilter.url['route'] == 'catalog/product/add' || dvfilter.url['route'] == 'catalog/product/edit') {
        dvfilter.productForm.init();
    }

    /**
     DVFilter Module Setting
     **/
    if (dvfilter.url['route'] == 'module/dvfilter') {
        dvfilter.setting.init();
    }
});
