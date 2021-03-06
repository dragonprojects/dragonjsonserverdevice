<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerDevice
 */

namespace DragonJsonServerDevice\Api;

/**
 * API Klasse zur Verwaltung von Deviceverknüpfungen
 */
class Device
{
	use \DragonJsonServer\ServiceManagerTrait;

	/**
	 * Erstellt eine neue Deviceverknüpfung für den Account
	 * @param string $platform
	 * @param object $credentials
	 * @DragonJsonServerAccount\Annotation\Session
	 */
	public function createDevice($platform = 'browser', array $credentials = ['browser_id' => ''])
	{
		$serviceManager = $this->getServiceManager();
		
		$serviceSession = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
		$session = $serviceSession->getSession();
		$device = $serviceManager->get('\DragonJsonServerDevice\Service\Device')->createDevice($session->getAccountId(), $platform, $credentials);
		$data = $session->getData();
		$data['device'] = $device->toArray();
        $serviceSession->changeData($session, $data);
	}
	
    /**
	 * Entfernt die aktuelle Deviceverknüpfung für den Account
     * @throws \DragonJsonServer\Exception
	 * @DragonJsonServerAccount\Annotation\Session
	 */
	public function removeDevice()
	{
		$serviceManager = $this->getServiceManager();

		$sessionService = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
		$session = $sessionService->getSession();
		$data = $session->getData();
		if (!isset($data['device'])) {
			throw new \DragonJsonServer\Exception('missing device in session', ['session' => $session->toArray()]);
		}
		$serviceDevice = $serviceManager->get('\DragonJsonServerDevice\Service\Device');
		$device = $serviceDevice->getDeviceById($data['device']['device_id']);
		$serviceDevice->removeDevice($device);
		unset($data['device']);
		$sessionService->changeData($session, $data);
	}
	
    /**
	 * Entfernt die übergebene Deviceverknüpfung für den Account
	 * @param integer $device_id
     * @throws \DragonJsonServer\Exception
	 * @DragonJsonServerAccount\Annotation\Session
	 */
	public function removeDeviceByDeviceId($device_id)
	{
		$serviceManager = $this->getServiceManager();

		$sessionService = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
		$session = $sessionService->getSession();
		$serviceDevice = $serviceManager->get('\DragonJsonServerDevice\Service\Device');
		$device = $serviceDevice->getDeviceById($device_id);
		if ($session->getAccountId() != $device->getAccountId()) {
			throw new \DragonJsonServer\Exception(
				'account_id not match',
				['session' => $session->toArray(), 'device' => $device->getAccountId()]
			);
		}
		$serviceDevice->removeDevice($device);
		$data = $session->getData();
		if (isset($data['device']) && $data['device']['device_id'] == $device->getDeviceId()) {
			unset($data['device']);
			$sessionService->changeData($session, $data);
		}
	}
	
    /**
	 * Meldet den Account mit der übergebenen Deviceverknüpfung an
	 * @param string $platform
	 * @param object $credentials
	 * @return array
	 */
	public function loginDevice($platform = 'browser', array $credentials = ['browser_id' => ''])
	{
		$serviceManager = $this->getServiceManager();

		$device = $serviceManager->get('Device')->getDeviceByPlatformAndCredentials($platform, $credentials);
		$serviceSession = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
		$session = $serviceSession->createSession($device->getAccountId(), ['device' => $device->toArray()]);
		$serviceSession->setSession($session);
		return $session->toArray();
	}
	
    /**
	 * Gibt die Deviceverknüpfungen der Accounts zurück
	 * @return array
	 * @DragonJsonServerAccount\Annotation\Session
	 */
	public function getDevices()
	{
		$serviceManager = $this->getServiceManager();
		
		$sessionService = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
		$session = $sessionService->getSession();
		$devices = $serviceManager->get('\DragonJsonServerDevice\Service\Device')->getDevicesByAccountId($session->getAccountId());
		return $serviceManager->get('\DragonJsonServerDoctrine\Service\Doctrine')->toArray($devices);
	}
	
    /**
	 * Gibt die Einstellungen der Deviceplattformen zurück
	 * @return array
	 */
	public function getDeviceplatforms()
	{
        return $this->getServiceManager()->get('Config')['dragonjsonserverdevice']['deviceplatforms'];
	}
}
