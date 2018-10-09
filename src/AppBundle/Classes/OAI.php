<?php

namespace AppBundle\Classes;

use Naoned\OaiPmhServerBundle\DataProvider\any;
use Naoned\OaiPmhServerBundle\DataProvider\ArrayObject;
use Naoned\OaiPmhServerBundle\DataProvider\DataProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class OAIController implements DataProviderInterface
{
    use ContainerAwareTrait;

    /**
     * @return string Repository name
     */
    public function getRepositoryName()
    {
        // TODO: Implement getRepositoryName() method.
    }

    /**
     * @return string Repository admin email
     */
    public function getAdminEmail()
    {
        // TODO: Implement getAdminEmail() method.
    }

    /**
     * @return \DateTime|string     Repository earliest update change on data
     */
    public function getEarliestDatestamp()
    {
        // TODO: Implement getEarliestDatestamp() method.
    }

    /**
     * @param  string $identifier [description]
     * @return array
     */
    public function getRecord($id)
    {
        // TODO: Implement getRecord() method.
    }

    /**
     * Search for records
     * @param  String|null $setTitle Title of wanted set
     * @param  \DateTime|null $from Date of last change «from»
     * @param  \DataTime|null $until Date of last change «until»
     * @return array|ArrayObject        List of items
     */
    public function getRecords($set = null, \DateTime $from = null, \DateTime $until = null)
    {
        // TODO: Implement getRecords() method.
    }

    /**
     * must return an array of arrays with keys «identifier» and «name»
     * @return array List of all sets, with identifier and name
     */
    public function getSets()
    {
        // TODO: Implement getSets() method.
    }

    /**
     * Tell me, this «record», in which «set» is it ?
     * @param  any $record An item of elements furnished by getRecords method
     * @return array         List of sets, the record belong to
     */
    public function getSetsForRecord($record)
    {
        // TODO: Implement getSetsForRecord() method.
    }

    /**
     * Transform the provided record in an array with Dublin Core, «dc_title»  style
     * @param  any $record An item of elements furnished by getRecords method
     * @return array         Dublin core data
     */
    public function dublinizeRecord($record)
    {
        // TODO: Implement dublinizeRecord() method.
    }

    /**
     * Check if sets are supported by data provider
     * @return boolean check
     */
    public function checkSupportSets()
    {
        // TODO: Implement checkSupportSets() method.
    }

    /**
     * Get identifier of id
     * @param  any $record An item of elements furnished by getRecords method
     * @return string        Record Id
     */
    public static function getRecordId($record)
    {
        // TODO: Implement getRecordId() method.
    }

    /**
     * Get last change date
     * @param  any $record An item of elements furnished by getRecords method
     * @return \DateTime|string     Record last change
     */
    public static function getRecordUpdated($record)
    {
        // TODO: Implement getRecordUpdated() method.
    }
}