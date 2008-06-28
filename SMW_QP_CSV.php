<?php
/**
 * CSV export for SMW Queries
 */

/**
 * Printer class for generating CSV output
 * @author Nathan R. Yergler
 * @note AUTOLOADED
 */
class SMWCsvResultPrinter extends SMWResultPrinter {
	protected $m_title = '';
	protected $m_description = '';

	protected function readParameters($params,$outputmode) {
		SMWResultPrinter::readParameters($params,$outputmode);
	
		// do additional processing here if we add optional
		// params

	} // readParameters

	public function getResult($results, $params, $outputmode) { 
	       // skip checks, results with 0 entries are normal
		$this->readParameters($params,$outputmode);
		return $this->getResultText($results,$outputmode) . $this->getErrorString($results);

	} // getResult

	public function getMimeType($res) {
		return 'text/csv';
	} // getMimeType

	protected function getResultText($res, $outputmode) {

		global $smwgIQRunningNumber, $wgSitename, $wgServer, $wgRequest;
		$result = '';

		if ($outputmode == SMW_OUTPUT_FILE) { // make CSV file

		   $csv = fopen('php://temp/maxmemory:'. (2*1024*1024), 'r+');

		   while ( $row = $res->getNext() ) {

		      $row_items = array();

		      foreach ($row as $field) {
			$growing = array();
			while (($object = $field->getNextObject()) !== false) {
			  $text = $object->getWikiValue();
			  $growing[] = $text;
			} // while...
			$row_items[] = implode(',', $growing);
			
		      } // foreach...

		      fputcsv($csv, $row_items);

		   } // while...


		   rewind($csv);
		   $result .= stream_get_contents($csv);

		} else { // just make link to feed

		       $label = "(CSV)";

			$link = $res->getQueryLink($label);
			$link->setParameter('csv','format');
			if ($this->m_title !== '') {
				$link->setParameter('title');
			}
			if ($this->m_description !== '') {
				$link->setParameter('description');
			}
			if (array_key_exists('limit', $this->m_params)) {
				$link->setParameter($this->m_params['limit'],'limit');
			} else { // use a reasonable default limit
				$link->setParameter(100,'limit');
			}

			$result .= $link->getText($outputmode,$this->mLinker);

			// is this useful?
			//smwfRequireHeadItem('ical' . $smwgIQRunningNumber, '<link rel="alternate" type="text/calendar" title="' . $this->m_title . '" href="' . $link->getURL() . '" />');
		}

		return $result;
	}

}

