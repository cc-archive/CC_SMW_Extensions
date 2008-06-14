<?php

$wgExtensionFunctions[] = 'CC_SMW_Setup';
$wgAutoloadClasses['SMWSumResultPrinter'] = dirname(__FILE__) . '/SMW_QP_Sum.php';
$wgAutoloadClasses['SMWCsvResultPrinter'] = dirname(__FILE__) . '/SMW_QP_CSV.php';

# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]       = 'ccseParserFunction_magic';

require_once("$IP/extensions/CC_SMW_Extensions/CC_SMW_pask.php");

function CC_SMW_Setup() {

    global $wgHooks, $wgParser, $wgExtensionCredits;

    $wgHooks['ParserBeforeStrip'][] = 'ccsefRegisterPAsk'; // register the <pask> parser hook

    ///// credits (see "Special:Version") 
    $wgExtensionCredits['parserhook'][] = array(
        'name'=>'CC SMW Extensions', 
	'version'=> '0.2', 
	'author'=>"Nathan Yergler", 
	'url'=>'http://wiki.creativecommons.org/Semantic_MediaWiki', 
	'description' => 'Simple extensions or customizations for SMW @ CC.');

    // register query printer formats
    require_once('extensions/SemanticMediaWiki/includes/SMW_QueryProcessor.php');

    SMWQueryProcessor::$formats['sum'] = 'SMWSumResultPrinter';
    SMWQueryProcessor::$formats['csv'] = 'SMWCsvResultPrinter';

} // CC_SMW_Setup

