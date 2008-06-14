<?php

function ccseParserFunction_magic ( &$magicWords, $langCode ) {
   # Add the magic word
   # The first array element is case sensitive, in this case it is not case sensitive
   # All remaining elements are synonyms for our parser function
   $magicWords['geocode'] = array( 0, 'geocode' );

   # unless we return true, other parser functions extensions won't get loaded.
   return true;
}

function ccseGeocode_Render( &$parser, $geo_string= '' ) {
   # The parser function itself
   # The input parameters are wikitext with templates expanded
   # The output should be wikitext too

   return "param1 is $param1 and param2 is $param2";
}
				 
/**
 * This hook registers a parser-hook to the current parser.
 * Note that parser hooks are something different than MW hooks
 * in general, which explains the two-level registration.
 */
function ccsefRegisterPAsk( &$parser, &$text, &$stripstate ) {
    $parser->setHook( 'pask', 'ccseProcessPAsk' );
    return true; // always return true, in order not to stop MW's hook processing!
}

/**
 * The <pask> parser hook processing part.
 */

function _ccse_request_lookup($match) {
   return $_GET[$match[1]];
}

function ccseProcessPAsk($text, $param, &$parser) {
    global $smwgIP;
    require_once($smwgIP . '/includes/SMW_GlobalFunctions.php');

    // pre-process the query, replacing parts w/request params
    $new_text = preg_replace_callback("|\{\{#request:([a-z_]+)\}\}|", "_ccse_request_lookup", $text);

    return smwfProcessInlineQuery( $new_text, $param, &$parser );
}

?>
