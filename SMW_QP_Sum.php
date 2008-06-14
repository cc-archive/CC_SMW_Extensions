<?php
/**
 * Print the sum of query results.
 * @author Nathan R. Yergler
 *

/**
 *
 * XXX
 * 
 * @note AUTOLOADED
 */
class SMWSumResultPrinter extends SMWResultPrinter {

	protected $mSep = '';
	protected $mTemplate = '';

	protected function readParameters($params,$outputmode) {
		SMWResultPrinter::readParameters($params,$outputmode);

		if (array_key_exists('sep', $params)) {
			$this->mSep = str_replace('_',' ',$params['sep']);
			if ($outputmode==SMW_OUTPUT_HTML) {
				$this->mSep = htmlspecialchars($this->mSep);
			}
		}
		if (array_key_exists('template', $params)) {
			$this->mTemplate = trim($params['template']);
		}
	}

	protected function getResultText($res,$outputmode) {
		global $wgTitle,$smwgStoreActive;

		// sum the last value of each result row
		$sum = 0;

		$row = $res->getNext();
		while ( $row !== false ) {

		      $last_col = array_pop($row);

		      // get the numeric value
		      // XXX we should really type check for
		      // SMWNumberValue here

		      $sum += array_pop($last_col->getContent())->getNumericValue();

		      // next row
		      $row = $res->getNext();

		} // for each row...

		return $sum;

	} // getResultText

} // SMSumResultPrinter
