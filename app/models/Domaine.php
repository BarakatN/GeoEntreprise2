<?php
namespace GeoEntreprise\Models;
class Domaine extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $Id_domaine;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=false)
     */
    public $Nom;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=false)
     */
    public $Description;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("domaine");
        $this->hasMany('id_domaine', 'DomaineHasEntreprise', 'domaine_id_domaine', ['alias' => 'DomaineHasEntreprise']);
         $this->hasMany('id_etab', 'DomaineHasEtablissement', 'etablissement_id_etab', ['alias' => 'DomaineHasEtablissement']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'domaine';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Domaine[]|Domaine|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Domaine|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
