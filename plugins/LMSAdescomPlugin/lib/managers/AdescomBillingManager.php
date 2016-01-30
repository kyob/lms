<?php

/*
 *  LMS version 1.11-git
 *
 *  Copyright (C) 2001-2013 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

/**
 * AdescomBillingManager
 *
 * @author Maciej Lew <maciej.lew.1987@gmail.com>
 */
class AdescomBillingManager
{
    /**
     * Returns billing records for CLIDs
     * 
     * @param array $clids CLIDs
     * @param string $dateFrom Date from
     * @param string $dateTo Date to
     * @param array $options Options
     * @param AdescomSoapClient $connection
     * @return stdClass Billing records
     */
    public function getBillingForCLIDs(array $clids, $dateFrom, $dateTo, array $options, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $clids_range = new stdClass();
        $clids_range->items = array();

        if (is_array($clids)) {
            foreach ($clids as $callerid) {
                $clids_range->items[] = $callerid;
            }
        }

        $response = $connection->getBillingForCLIDs($clids_range, $dateFrom, $dateTo, $options);

        $records = new stdClass();
        $records->items = array();

        if (property_exists($response, 'totalCount')) {
            $records->total = $response->totalCount;
        }

        if (property_exists($response, 'totalPrice')) {
            $records->totalPrice = $response->totalPrice;
        }

        if (property_exists($response, 'totalDuration')) {
            $records->totalDuration = $response->totalDuration;
        }

        if (is_array($response->items)) {
            foreach ($response->items as $record) {
                $records->items[] = self::getCDRArray($record);
            }
        }

        return $records;
    }

    /**
     * Returns billing records for client
     * 
     * @param int $clientid Client id
     * @param string $dateFrom Date from
     * @param string $dateTo Date to
     * @param array $options Options
     * @param AdescomSoapClient $connection Connection
     * @return \stdClass Billing records
     */
    public function getBillingForClient($clientid, $dateFrom, $dateTo, array $options, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getBillingForClientByExternalID($clientid, $dateFrom, $dateTo, $options);
        
        $records = new stdClass();
        $records->items = array();

        if (property_exists($response, 'totalCount')) {
            $records->total = $response->totalCount;
        }

        if (property_exists($response, 'totalPrice')) {
            $records->totalPrice = $response->totalPrice;
        }

        if (property_exists($response, 'totalDuration')) {
            $records->totalDuration = $response->totalDuration;
        }

        if (is_array($response->items)) {
            foreach ($response->items as $record) {
                $records->items[] = self::getCDRArray($record);
            }
        }

        return $records;
    }

    /**
     * Returns billing records for trunk
     * 
     * @param string $trunknr Trunk number
     * @param string $dateFrom Date from
     * @param string $dateTo Date to
     * @param array $options Options
     * @param AdescomSoapClient $connection Connection
     * @return \stdClass Billing records
     */
    public function getBillingForTrunk($trunknr, $dateFrom, $dateTo, array $options, AdescomSoapClient $connection = null)
    {
        if ($connection === null) {
            $connection = AdescomConnection::getConnection();
        }

        $response = $connection->getBillingForTrunk($trunknr, $dateFrom, $dateTo, $options);

        $records = new stdClass();
        $records->items = array();

        if (property_exists($response, 'totalCount')) {
            $records->total = $response->totalCount;
        }

        if (property_exists($response, 'totalPrice')) {
            $records->totalPrice = $response->totalPrice;
        }

        if (property_exists($response, 'totalDuration')) {
            $records->totalDuration = $response->totalDuration;
        }

        if (is_array($response->items)) {
            foreach ($response->items as $record) {
                $records->items[] = self::getCDRArray($record);
            }
        }

        return $records;
    }
    
    /**
     * Converts CDR object to CDR array
     * 
     * @param stdClass $cdr CDR object
     * @return array CDR array
     */
    static private function getCDRArray(stdClass $cdr = null)
    {
        if ($cdr === null) {
            return null;
        }

        $result = array();
        $result['id'] = $cdr->id;
        $result['start_date'] = strtotime($cdr->startDate);
        $result['end_date'] = strtotime($cdr->endDate);
        $result['duration'] = $cdr->duration;
        $result['outgoing'] = $cdr->outgoing;
        $result['source'] = $cdr->source;
        $result['destination'] = $cdr->destination;
        $result['price'] = $cdr->price;
        $result['fraction'] = $cdr->fraction;
        $result['prefix'] = $cdr->prefix;
        $result['prefix_name'] = $cdr->prefixName;
        $result['tg_in'] = $cdr->tgInNr;
        $result['tg_out'] = $cdr->tgOutNr;
        $result['price_per_minute'] = $cdr->price / ($cdr->duration / 60);

        return $result;
    }

    /**
     * Converts report object to report array
     * 
     * @param stdClass $report Report object
     * @return array Report array
     */
    static private function getReportArray(stdClass $report = null)
    {
        if ($report === null) {
            return null;
        }

        $result = array();
        $result['date'] = $report->date;
        $result['fraction'] = $report->fraction;
        $result['period'] = $report->period;
        $result['callerID'] = $report->callerID;
        $result['count'] = $report->count;
        $result['durationTotal'] = $report->durationTotal;
        $result['durationAverage'] = $report->durationAverage;
        $result['costTotalExcludingTaxes'] = $report->costTotalExcludingTaxes;
        $result['costAverageExcludingTaxes'] = $report->costAverageExcludingTaxes;
        $result['taxesTotal'] = $report->taxesTotal;
        $result['taxesAverage'] = $report->taxesAverage;
        $result['costTotalIncludingTaxes'] = $report->costTotalIncludingTaxes;
        $result['costAverageIncludingTaxes'] = $report->costAverageIncludingTaxes;

        return $result;
    }

}
