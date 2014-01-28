<?php

namespace Alchemy\Phrasea\Model\Proxies\__CG__\Alchemy\Phrasea\Model\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class FtpExport extends \Alchemy\Phrasea\Model\Entities\FtpExport implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'crash', 'nbretry', 'mail', 'addr', 'ssl', 'login', 'pwd', 'passif', 'destfolder', 'sendermail', 'textMailSender', 'textMailReceiver', 'usrId', 'foldertocreate', 'logfile', 'elements', 'created', 'updated');
        }

        return array('__isInitialized__', 'id', 'crash', 'nbretry', 'mail', 'addr', 'ssl', 'login', 'pwd', 'passif', 'destfolder', 'sendermail', 'textMailSender', 'textMailReceiver', 'usrId', 'foldertocreate', 'logfile', 'elements', 'created', 'updated');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (FtpExport $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setCrash($crash)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCrash', array($crash));

        return parent::setCrash($crash);
    }

    /**
     * {@inheritDoc}
     */
    public function getCrash()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCrash', array());

        return parent::getCrash();
    }

    /**
     * {@inheritDoc}
     */
    public function incrementCrash()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'incrementCrash', array());

        return parent::incrementCrash();
    }

    /**
     * {@inheritDoc}
     */
    public function setNbretry($nbretry)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNbretry', array($nbretry));

        return parent::setNbretry($nbretry);
    }

    /**
     * {@inheritDoc}
     */
    public function getNbretry()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNbretry', array());

        return parent::getNbretry();
    }

    /**
     * {@inheritDoc}
     */
    public function setMail($mail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMail', array($mail));

        return parent::setMail($mail);
    }

    /**
     * {@inheritDoc}
     */
    public function getMail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMail', array());

        return parent::getMail();
    }

    /**
     * {@inheritDoc}
     */
    public function setAddr($addr)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAddr', array($addr));

        return parent::setAddr($addr);
    }

    /**
     * {@inheritDoc}
     */
    public function getAddr()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAddr', array());

        return parent::getAddr();
    }

    /**
     * {@inheritDoc}
     */
    public function setSsl($ssl)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSsl', array($ssl));

        return parent::setSsl($ssl);
    }

    /**
     * {@inheritDoc}
     */
    public function isSsl()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isSsl', array());

        return parent::isSsl();
    }

    /**
     * {@inheritDoc}
     */
    public function setLogin($login)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLogin', array($login));

        return parent::setLogin($login);
    }

    /**
     * {@inheritDoc}
     */
    public function getLogin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLogin', array());

        return parent::getLogin();
    }

    /**
     * {@inheritDoc}
     */
    public function setPwd($pwd)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPwd', array($pwd));

        return parent::setPwd($pwd);
    }

    /**
     * {@inheritDoc}
     */
    public function getPwd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPwd', array());

        return parent::getPwd();
    }

    /**
     * {@inheritDoc}
     */
    public function setPassif($passif)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassif', array($passif));

        return parent::setPassif($passif);
    }

    /**
     * {@inheritDoc}
     */
    public function isPassif()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPassif', array());

        return parent::isPassif();
    }

    /**
     * {@inheritDoc}
     */
    public function setDestfolder($destfolder)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDestfolder', array($destfolder));

        return parent::setDestfolder($destfolder);
    }

    /**
     * {@inheritDoc}
     */
    public function getDestfolder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDestfolder', array());

        return parent::getDestfolder();
    }

    /**
     * {@inheritDoc}
     */
    public function setSendermail($sendermail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSendermail', array($sendermail));

        return parent::setSendermail($sendermail);
    }

    /**
     * {@inheritDoc}
     */
    public function getSendermail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSendermail', array());

        return parent::getSendermail();
    }

    /**
     * {@inheritDoc}
     */
    public function setTextMailSender($textMailSender)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTextMailSender', array($textMailSender));

        return parent::setTextMailSender($textMailSender);
    }

    /**
     * {@inheritDoc}
     */
    public function getTextMailSender()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTextMailSender', array());

        return parent::getTextMailSender();
    }

    /**
     * {@inheritDoc}
     */
    public function setTextMailReceiver($textMailReceiver)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTextMailReceiver', array($textMailReceiver));

        return parent::setTextMailReceiver($textMailReceiver);
    }

    /**
     * {@inheritDoc}
     */
    public function getTextMailReceiver()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTextMailReceiver', array());

        return parent::getTextMailReceiver();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsrId($usrId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsrId', array($usrId));

        return parent::setUsrId($usrId);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsrId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsrId', array());

        return parent::getUsrId();
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(\Alchemy\Phrasea\Application $app)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', array($app));

        return parent::getUser($app);
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(\User_Adapter $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', array($user));

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setFoldertocreate($foldertocreate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFoldertocreate', array($foldertocreate));

        return parent::setFoldertocreate($foldertocreate);
    }

    /**
     * {@inheritDoc}
     */
    public function getFoldertocreate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFoldertocreate', array());

        return parent::getFoldertocreate();
    }

    /**
     * {@inheritDoc}
     */
    public function setLogfile($logfile)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLogfile', array($logfile));

        return parent::setLogfile($logfile);
    }

    /**
     * {@inheritDoc}
     */
    public function isLogfile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isLogfile', array());

        return parent::isLogfile();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreated(\DateTime $created)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreated', array($created));

        return parent::setCreated($created);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreated', array());

        return parent::getCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdated(\DateTime $updated)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdated', array($updated));

        return parent::setUpdated($updated);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdated', array());

        return parent::getUpdated();
    }

    /**
     * {@inheritDoc}
     */
    public function addElement(\Alchemy\Phrasea\Model\Entities\FtpExportElement $elements)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addElement', array($elements));

        return parent::addElement($elements);
    }

    /**
     * {@inheritDoc}
     */
    public function removeElement(\Alchemy\Phrasea\Model\Entities\FtpExportElement $elements)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeElement', array($elements));

        return parent::removeElement($elements);
    }

    /**
     * {@inheritDoc}
     */
    public function getElements()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getElements', array());

        return parent::getElements();
    }

}