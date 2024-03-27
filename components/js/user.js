function scrollToBottom() {
    window.scrollTo(0, document.body.scrollHeight);
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(name)
{
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? value[1] : null;
}

function makePager(prevLinkURL, prevCaption, nextLinkURL, nextCaption) {
    var $result = $('<ul class="pager"></ul>');
    if (prevLinkURL) {
        $result.append('<li class="previous"><a href="' + prevLinkURL + '" class="previous-page" title="Previous Page"><span aria-hidden="true">&larr;</span><span class="hidden-xs"> ' + prevCaption + '</span></a></li>')
    }
    if (nextLinkURL) {
        $result.append('<li class="next"><a href="' + nextLinkURL + '" class="next-page" title="Next Page"><span class="hidden-xs">' + nextCaption + ' </span><span aria-hidden="true">&rarr;</span></a></li>')
    }
    return $result.wrap('<nav></nav>');
}

function extractPageLink(direction) {
    var $items = $(".sidebar li:not(:empty):not(.sidebar-nav-head):not(.js-whatsnew-item)");
    var activeIndex = $items.index($(".sidebar li.active"));
    if (direction === 'backward') {
        activeIndex -= 1;
    }
    return $items.slice(activeIndex).filter(function (i, item) {
        return $(item).find('>a').length;
    }).first().find('a');
}

function buildLinkCaption($link) {
    return  $link.closest('li.sidebar-nav-head').find('span').first().text().trim() + '::' + $link.text().trim();
}


function handleThemeSelection() {
    $("#themes").on("click", "a", function (e) {
        setCookie('theme', $(this).text(), 360);
        setCookie('demo_theme', '', -1);
        location.reload();
        e.preventDefault();
    });
}

function closeCallback () {
    return true;
}

function showModal() {
    $('a[data-bootbox]').on("click", function() {
        var elementId = $(this).data("bootbox");
        var elementContent = $(elementId).html();
        bootbox.dialog({
            size: 'large',
            title: "",
            message: elementContent,
            backdrop: true,
            onEscape: closeCallback,
            buttons: {
                cancel: {
                    label: 'Close',
                    callback: closeCallback
                }              
            }
        });
    });
}

function handleLanguageSelection() {
     $("#langs").on("click", "a", function (e) {
         var query = jQuery.query;
         query = query.set('lang', $(this).data('lang'));
         window.location = query;
         e.preventDefault();
     });
}

function addPagerToDescritption() {
    var $descriptionBlock = $('div.description');
    if ($descriptionBlock.length === 0) {
        return;
    }
    var $prevLink = extractPageLink('backward');
    var $nextLink = extractPageLink('forward');
    var $pager = makePager(
        $prevLink.attr('href'), buildLinkCaption($prevLink),
        $nextLink.attr('href'), buildLinkCaption($nextLink)
    );
    $descriptionBlock.append($pager);
    setTimeout(function(){$pager.css('opacity', 1)}, 0);
}

function highlightCode() {
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
}

function expandDetailedDescriptionWindow() {
    $('[id^=detailedDescriptionModal] > div.modal-dialog').addClass('modal-lg');
}

function initDetailedDescriptionLinks() {
    $('.detailed-description').on('click', function() {
        $('[data-target^=#detailedDescriptionModal]').first().trigger('click');
    });
}

function createPopover() {
    $('[data-input-popover]').each(function(index, value) {
        $(this).data("toggle", "popover");
        $(this).data("trigger", "hover");        
        $(this).data("placement", "top");        
        $(this).data("content", $(this).data("input-popover"));
        $(this).popover();        
    });
}

function getCountryFormat(item) {
    return '<span class="flag-icon flag-icon-' + item.fields.code2 + '"></span> ' + item.text;
}

function initCustomEditors() {
    var $customEditor = $('textarea[data-code-mirror-editor]').first();
    if ($customEditor.length > 0) {    
        var editor = CodeMirror.fromTextArea($customEditor.get(0), {
            lineNumbers: true,
            matchBrackets: true,
        });
        editor.on('change', function(cMirror){
            $customEditor.val(cMirror.getValue());
        });        
    }
}

function initDescriptionActionLinks() {

    function initActionLink($link, operationName) {
        if ($link.length > 0) {
            $('.description-' + operationName).each(function(index, value) {
                if ($link.attr('href') && $link.attr('href') != '#') {
                    $(this).attr('href', $link.attr('href'));
                } else {
                    $(this).on('click', function(){
                        $link.trigger('click');
                    });
                }
            });
        }
    }

    var $addButton = $('.pgui-add').first();
    var $firstEditLink = $('span.operation-item[data-column-name="edit"] a').first();
    var $firstViewLink = $('span.operation-item[data-column-name="view"] a').first();
    var $firstCopyLink = $('span.operation-item[data-column-name="copy"] a').first();

    initActionLink($addButton, 'insert');
    initActionLink($firstEditLink, 'edit');
    initActionLink($firstViewLink, 'view');
    initActionLink($firstCopyLink, 'copy');
}

function initSpoiler() {
    $(".panel div.clickable").on("click", function (e) {
        var $panel = $(this).parent('.panel');
        var $panel_body = $panel.children('.panel-body');
        var $display = $panel_body.css('display');

        if ($display == 'block') {
            $panel_body.slideUp();
            $panel.find('.description-spoiler').removeClass('description-spoiler-collapsed');
        } else if ($display == 'none') {
            $panel_body.slideDown();
            $panel.find('.description-spoiler').addClass('description-spoiler-collapsed');
        }
    });
}

function showVideoLink() {
    var $videoLink = $('span.demo-video-link').first();
    if ($videoLink.length > 0) {
        var $pageHeader = $('h1').first();
        if ($pageHeader) {
            $(
                '<div class="demo-video">' +
                '<a href="' + $videoLink.attr('data-demo-video-link') + '" target="_blank">' +
                '<span class="hidden-xs hidden-sm">Watch video</span>' +
                '<span class="icon-play"></span>' +
                '</a>' +
                '</div>'
            ).insertBefore($pageHeader);
        }
    }
}

function handleFormWizard() {
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        $form = $('div.stepwizard').closest('form'),
        currentStepNumber = 1;

    function validateContent($stepToGo) {
        var $fromStepContent = $(".setup-content:visible");
        $form.valid();
        if ($fromStepContent.find('.form-group.has-error').length > 0 ) {
            navListItems.each(function(index) {
                if (index > currentStepNumber - 1) {
                    $(this).attr('disabled', 'disabled');
                }
            });
        } else {
            $stepToGo.removeAttr('disabled');
            $(".form-group").removeClass("has-error");
            $(".form-group span[generated=true]").remove();
        }
    }

    function showStepContent($stepItem) {
        if (($stepItem.length > 0) && !$stepItem.attr('disabled')) {
            var $target = $($stepItem.attr('href'));
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $stepItem.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
            $target.show();
            currentStepNumber = $stepItem.data('step-number');

            $('.js-previous').attr('disabled', currentStepNumber == 1);
            if (currentStepNumber == 3) {
                $('.js-next').hide();
                $('.js-primary-save').show();
            } else {
                $('.js-next').show();
                $('.js-primary-save').hide();
            }
        }
    }

    navListItems.click(function (e) {
        e.preventDefault();
        var $item = $(this);

        if ($item.attr('disabled') || $item.hasClass('btn-primary')) {
            return;
        }

        validateContent($item);
        showStepContent($item);
    });

    $('.js-next').click(function(){
        var $curStep = $(".setup-content:visible"),
            curStepBtn = $curStep.attr("id"),
            $nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");

        validateContent($nextStepWizard);
        showStepContent($nextStepWizard);
    });

    $('.js-previous').click(function(){
        var curStep = $(".setup-content:visible"),
            curStepBtn = curStep.attr("id"),
            $prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
        
        showStepContent($prevStepWizard);
    });
}

function runDemoTour() {
    require(['../../external_data/libs/enjoyhint/enjoyhint', '../../external_data/libs/enjoyhint/jquery.scrollTo.min'], function () {
        var enjoyhint_instance = new EnjoyHint({});

        var enjoyhint_script_steps = [
            {
                'next #navbar': 'Welcome to the PHP Generator Feature Demo.<br>Lets consider briefly how it is arranged.'
            },
            {
                'next .sidebar': 'On the left you can see the pages are grouped by similar topics.<br>Each page focused on one particular feature.'
            },
            {
                'next .well.description': 'It is a page description. It provides detail information about the feature the page demonstrates.'
            },
            {
                'next a.previous-page': 'Navigation buttons located under the page description. Click this button to back to the previous page.'
            },
            {
                'next a.next-page': 'Click this navigation button to go to the next page.',
                showSkip: false,
                'nextButton': {text: "Let's start!"}
            }
        ];

        enjoyhint_instance.set(enjoyhint_script_steps);

        enjoyhint_instance.run();
    })
}

function handleDemoTour() {
    if ($('span.run-demo-tour').length > 0) {
        runDemoTour();
    }

    $('a.run-demo-tour').click(function(){
        runDemoTour();
    })
}

function expandFirstDetail() {
    var $firstExpandDetailsButton = $('a.js-expand-details').first();   
    if (($firstExpandDetailsButton.length > 0) && 
       (eventData = $._data($firstExpandDetailsButton.get(0), "events")) &&
       (eventData.click)) 
    {
        $firstExpandDetailsButton.click();
        $(window).scrollTop(0);
    }
    else {
        setTimeout(expandFirstDetail, 100); 
    }     
}

require(['jquery'], function () {
    $(function () {
        handleThemeSelection();
        handleLanguageSelection();
        addPagerToDescritption();
        expandDetailedDescriptionWindow();
        initDetailedDescriptionLinks();
        highlightCode();
        showModal();
        createPopover();
        initDescriptionActionLinks();
        initSpoiler();
        showVideoLink();                
        handleFormWizard();
        handleDemoTour();
    });
});