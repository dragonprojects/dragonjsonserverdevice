<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2013 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerDevice
 */

namespace DragonJsonServerDevice\Entity;

/**
 * Entityklasse einer Deviceverknüpfung
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="devices")
 */
class Device
{
	use \DragonJsonServerDoctrine\Entity\ModifiedTrait;
	use \DragonJsonServerDoctrine\Entity\CreatedTrait;
	use \DragonJsonServerAccount\Entity\AccountIdTrait;
	
	/** 
	 * @Doctrine\ORM\Mapping\Id 
	 * @Doctrine\ORM\Mapping\Column(type="integer")
	 * @Doctrine\ORM\Mapping\GeneratedValue
	 **/
	protected $device_id;
	
	/** 
	 * @Doctrine\ORM\Mapping\Column(type="string")
	 **/
	protected $platform;
	
	/** 
	 * @Doctrine\ORM\Mapping\Column(type="string")
	 **/
	protected $credentials;
	
	/**
	 * Gibt die ID der Deviceverknüpfung zurück
	 * @return integer
	 */
	public function getDeviceId()
	{
		return $this->device_id;
	}
	
	/**
	 * Setzt die Plattform der Deviceverknüpfung
	 * @param string $platform
	 * @return Device
	 */
	public function setPlatform($platform)
	{
		$this->platform = $platform;
		return $this;
	}
	
	/**
	 * Gibt die Plattform der Deviceverknüpfung zurück
	 * @return string
	 */
	public function getPlatform()
	{
		return $this->platform;
	}
	
	/**
	 * Setzt die Credentials der Deviceverknüpfung
	 * @param string $credentials
	 * @return Device
	 */
	public function setCredentials($credentials)
	{
		$this->credentials = $credentials;
		return $this;
	}
	
	/**
	 * Gibt die Credentials der Deviceverknüpfung zurück
	 * @return string
	 */
	public function getCredentials()
	{
		return $this->credentials;
	}
	
	/**
	 * Gibt die Attribute der Deviceverknüpfung als Array zurück
	 * @return array
	 */
	public function toArray()
	{
		return [
			'device_id' => $this->getDeviceId(),
			'modified' => $this->getModified(),
			'created' => $this->getCreated(),
			'account_id' => $this->getAccountId(),
			'platform' => $this->getPlatform(),
		];
	}
}
