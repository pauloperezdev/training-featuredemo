<?php

function extractLessCode($sectionName, $fileName) {
    $handle = fopen("components/assets/less/" . $fileName . ".less", "r");
    $body = '';
    if ($handle) {
        $inSection = false;
        while (($line = fgets($handle)) !== false && !(strpos($line, "</$sectionName>"))) {
            if (strpos($line, "<$sectionName>")) {
                $inSection = true;
                continue;
            }
            if ($inSection) {
                $body = $body . $line;
            }
        }

        fclose($handle);
    }
    return '<pre><code class="css">' . htmlspecialchars($body) . '</code></pre>';
}

function extractTemplateFileCode($fileName) {
    $body = file_get_contents($fileName);
    return '<pre><code class="tpl">' . htmlspecialchars($body) . '</code></pre>';
}

/** @param ReflectionFunctionAbstract $func
 *  @return string
 */
function extractReflectionFunctionCode($func) {
    $fileName = $func->getFileName();
    $source = file($fileName);
    $startLine = $func->getStartLine() - 1;
    $endLine = $func->getEndLine();
    $length = $endLine - $startLine;
    $body = implode("", array_slice($source, $startLine, $length));
    return '<pre><code class="php">' . htmlspecialchars($body) . '</code></pre>';
}

function extractFunctionCode($functionName) {
    return extractReflectionFunctionCode(new ReflectionFunction($functionName));
}

function extractMethodCode($object, $methodName) {
    return extractReflectionFunctionCode(new ReflectionMethod($object, $methodName));
}

/**
 * @param Page $page
 * @param array|string $events
 * @return string
 */
function extractClientEventCode($page, $events) {
    $grid = $page->getGrid();
    $listings = array();

    if (is_scalar($events)) {
        $events = array($events);
    }

    foreach ($events as $event) {
        switch ($event) {
            case 'OnBeforePageLoad':
                $body = $page->GetCustomClientScript();
                break;
            case 'OnAfterPageLoad':
                $body = $page->GetOnPageLoadedClientScript();
                break;
            case 'OnInsertFormValidate':
                $body = $grid->GetInsertClientValidationScript();
                break;
            case 'OnEditFormValidate':
                $body = $grid->GetEditClientValidationScript();
                break;
            case 'OnInsertFormEditorValueChanged':
                $body = $grid->GetInsertClientEditorValueChangedScript();
                break;
            case 'OnEditFormEditorValueChanged':
                $body = $grid->GetEditClientEditorValueChangedScript();
                break;
            case 'OnInsertFormLoaded':
                $body = $grid->GetInsertClientFormLoadedScript();
                break;
            case 'OnEditFormLoaded':
                $body = $grid->GetEditClientFormLoadedScript();
                break;
            case 'OnCalculateControlValues':
                $body = $grid->getCalculateControlValuesScript();
                break;
            default:
                exit("code_extractor.php: unknown client event $event");
        }

        $listings[$event] = $body;
    }

    $result = '<br>';
    foreach ($listings as $event => $listing) {
        $result .= sprintf(
            "<p><pre><code class=\"js\">// %s event body\n %s</code></pre></p>",
            $event,
            htmlspecialchars($listing)
        );
    }

    return $result;
}

function hostIsSqlMaestro() {
    $host = $_SERVER['HTTP_HOST'];
    return strpos($host, 'sqlmaestro') !== false;
}
