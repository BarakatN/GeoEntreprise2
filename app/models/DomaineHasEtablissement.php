<?php
namespace GeoEntreprise\Models;
class DomaineHasEtablissement extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $Domaine_id_domaine;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $Etablissement_id_etab;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("domaine_has_etablissement");
         $this->belongsTo('domaine_id_domaine', '\Domaine', 'id_domaine', ['alias' => 'Domaine']);
        $this->belongsTo('etablissement_id_etab', '\Etablissement', 'id_etab', ['alias' => 'Etablissement']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'domaine_has_etablissement';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return DomaineHasEtablissement[]|DomaineHasEtablissement|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return DomaineHasEtablissement|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
