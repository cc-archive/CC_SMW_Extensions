<?php

$wgExtensionFunctions[] = 'semmath_Setup';
$wgAutoloadClasses['SMSumResultPrinter'] = dirname(__FILE__) . '/SM_QP_Sum.php';
$wgAutoloadClasses['SMWCsvResultPrinter'] = dirname(__FILE__) . '/SMW_QP_CSV.php';

function semmath_Setup() {

require_once('extensions/SemanticMediaWiki/includes/SMW_QueryProcessor.php');

SMWQueryProcessor::$formats['sum'] = 'SMSumResultPrinter';
SMWQueryProcessor::$formats['csv'] = 'SMWCsvResultPrinter';

}

