<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2013 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Controller\Root;

use Alchemy\Phrasea\Application as PhraseaApplication;
use Alchemy\Phrasea\Exception\InvalidArgumentException;
use Alchemy\Phrasea\Notification\Receiver;
use Alchemy\Phrasea\Notification\Mail\MailRequestEmailUpdate;
use Alchemy\Phrasea\Form\Login\PhraseaRenewPasswordForm;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Account implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $app['account.controller'] = $this;

        $controllers->before(function() use ($app) {
                $app['firewall']->requireAuthentication();
            });

        // Displays current logged in user account
        $controllers->get('/', 'account.controller:displayAccount')
            ->bind('account');

        // Updates current logged in user account
        $controllers->post('/', 'account.controller:updateAccount')
            ->bind('submit_update_account');

        // Displays email update form
        $controllers->get('/reset-email/', 'account.controller:displayResetEmailForm')
            ->bind('account_reset_email');

        // Submits a new email for the current logged in account
        $controllers->post('/reset-email/', 'account.controller:resetEmail')
            ->bind('reset_email');

        // Displays current logged in user access and form
        $controllers->get('/access/', 'account.controller:accountAccess')
            ->bind('account_access');

        // Displays and update current logged-in user password
        $controllers->match('/reset-password/', 'account.controller:resetPassword')
            ->bind('reset_password');

        // Displays current logged in user open sessions
        $controllers->get('/security/sessions/', 'account.controller:accountSessionsAccess')
            ->bind('account_sessions');

        // Displays all applications that can access user informations
        $controllers->get('/security/applications/', 'account.controller:accountAuthorizedApps')
            ->bind('account_auth_apps');

        // Displays a an authorized app grant
        $controllers->get('/security/application/{application_id}/grant/', 'account.controller:grantAccess')
            ->assert('application_id', '\d+')
            ->bind('grant_app_access');

        return $controllers;
    }

    /**
     * Reset Password
     *
     * @param  Application $app
     * @param  Request     $request
     * @return Response
     */
    public function resetPassword(Application $app, Request $request)
    {
        $form = $app->form(new PhraseaRenewPasswordForm());

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();

                $password = $data['password'];
                $passwordConfirm = $data['passwordConfirm'];

                $user = $app['authentication']->getUser();

                if ($password !== $passwordConfirm) {
                    $app->addFlash('error', _('forms::les mots de passe ne correspondent pas'));
                } elseif (strlen(trim($password)) < 5) {
                    $app->addFlash('error', _('forms::la valeur donnee est trop courte'));
                } elseif (trim($password) != str_replace(array("\r\n", "\n", "\r", "\t", " "), "_", $password)) {
                    $app->addFlash('error', _('forms::la valeur donnee contient des caracteres invalides'));
                } elseif ($app['auth.password-encoder']->isPasswordValid($user->get_password(), $data['oldPassword'], $user->get_nonce())) {
                    $user->set_password($passwordConfirm);
                    $app->addFlash('success', _('login::notification: Mise a jour du mot de passe avec succes'));

                    return $app->redirect($app->path('account'));
                } else {
                    $app->addFlash('error', _('Invalid password provided'));
                }
            }
        }

        return $app['twig']->render('account/change-password.html.twig', array(
            'form'  => $form->createView(),
            'login' => new \login(),
        ));
    }

    /**
     * Reset Email
     *
     * @param  Application      $app
     * @param  Request          $request
     * @return RedirectResponse
     */
    public function resetEmail(PhraseaApplication $app, Request $request)
    {
        if (null === ($password = $request->request->get('form_password')) || null === ($email = $request->request->get('form_email')) || null === ($emailConfirm = $request->request->get('form_email_confirm'))) {

            $app->abort(400, _('Could not perform request, please contact an administrator.'));
        }

        $user = $app['authentication']->getUser();

        if (!$app['auth.password-encoder']->isPasswordValid($user->get_password(), $password, $user->get_nonce())) {
            $app->addFlash('error', _('admin::compte-utilisateur:ftp: Le mot de passe est errone'));

            return $app->redirect($app->path('account_reset_email'));
        }

        if (!\Swift_Validate::email($email)) {
            $app->addFlash('error', _('forms::l\'email semble invalide'));

            return $app->redirect($app->path('account_reset_email'));
        }

        if ($email !== $emailConfirm) {
            $app->addFlash('error', _('forms::les emails ne correspondent pas'));

            return $app->redirect($app->path('account_reset_email'));
        }

        $date = new \DateTime('1 day');
        $token = $app['tokens']->getUrlToken(\random::TYPE_EMAIL, $app['authentication']->getUser()->get_id(), $date, $app['authentication']->getUser()->get_email());
        $url = $app['phraseanet.registry']->get('GV_ServerName') . 'account/reset-email/?token=' . $token;

        try {
            $receiver = Receiver::fromUser($app['authentication']->getUser());
        } catch (InvalidArgumentException $e) {
            $app->addFlash('error', _('phraseanet::erreur: echec du serveur de mail'));

            return $app->redirect($app->path('account_reset_email'));
        }

        $mail = MailRequestEmailUpdate::create($app, $receiver, null);
        $mail->setButtonUrl($url);
        $mail->setExpiration($date);

        $app['notification.deliverer']->deliver($mail);

        $app->addFlash('info', _('admin::compte-utilisateur un email de confirmation vient de vous etre envoye. Veuillez suivre les instructions contenue pour continuer'));

        return $app->redirect($app->path('account'));
    }

    /**
     * Display reset email form
     *
     * @param  Application $app
     * @param  Request     $request
     * @return Response
     */
    public function displayResetEmailForm(Application $app, Request $request)
    {
        if (null !== $token = $request->query->get('token')) {
            try {
                $datas = $app['tokens']->helloToken($token);
                $user = \User_Adapter::getInstance((int) $datas['usr_id'], $app);
                $user->set_email($datas['datas']);
                $app['tokens']->removeToken($token);

                $app->addFlash('success', _('admin::compte-utilisateur: L\'email a correctement ete mis a jour'));

                return $app->redirect($app->path('account'));
            } catch (\Exception $e) {
                $app->addFlash('error', _('admin::compte-utilisateur: erreur lors de la mise a jour'));

                return $app->redirect($app->path('account'));
            }
        }

        return $app['twig']->render('account/reset-email.html.twig');
    }

    /**
     * Display authorized applications that can access user informations
     *
     * @param Application $app            A Silex application where the controller is mounted on
     * @param Request     $request        The current request
     * @param Integer     $application_id The application id
     *
     * @return JsonResponse
     */
    public function grantAccess(Application $app, Request $request, $application_id)
    {
        if (!$request->isXmlHttpRequest() || !array_key_exists($request->getMimeType('json'), array_flip($request->getAcceptableContentTypes()))) {
            $app->abort(400, _('Bad request format, only JSON is allowed'));
        }

        $error = false;

        try {
            $account = \API_OAuth2_Account::load_with_user(
                $app
                , new \API_OAuth2_Application($app, $application_id)
                , $app['authentication']->getUser()
            );

            $account->set_revoked((bool) $request->query->get('revoke'), false);
        } catch (\Exception_NotFound $e) {
            $error = true;
        }

        return $app->json(array('success' => !$error));
    }

    /**
     * Display account base access
     *
     * @param  Application $app     A Silex application where the controller is mounted on
     * @param  Request     $request The current request
     * @return Response
     */
    public function accountAccess(Application $app, Request $request)
    {
        require_once $app['phraseanet.registry']->get('GV_RootPath') . 'lib/classes/deprecated/inscript.api.php';

        return $app['twig']->render('account/access.html.twig', array(
            'inscriptions' => giveMeBases($app, $app['authentication']->getUser()->get_id())
        ));
    }

    /**
     * Display authorized applications that can access user informations
     *
     * @param  Application $app     A Silex application where the controller is mounted on
     * @param  Request     $request The current request
     * @return Response
     */
    public function accountAuthorizedApps(Application $app, Request $request)
    {
        return $app['twig']->render('account/authorized_apps.html.twig', array(
            "applications" => \API_OAuth2_Application::load_app_by_user($app, $app['authentication']->getUser()),
        ));
    }

    /**
     * Display account session accesss
     *
     * @param  Application $app     A Silex application where the controller is mounted on
     * @param  Request     $request The current request
     * @return Response
     */
    public function accountSessionsAccess(Application $app, Request $request)
    {
        $dql = 'SELECT s FROM Entities\Session s
            WHERE s.usr_id = :usr_id
            ORDER BY s.created DESC';

        $query = $app['EM']->createQuery($dql);
        $query->setParameters(array('usr_id' => $app['session']->get('usr_id')));
        $sessions = $query->getResult();

        return $app['twig']->render('account/sessions.html.twig', array('sessions' => $sessions));
    }

    /**
     * Display account form
     *
     * @param  Application $app     A Silex application where the controller is mounted on
     * @param  Request     $request The current request
     * @return Response
     */
    public function displayAccount(Application $app, Request $request)
    {
        return $app['twig']->render('account/account.html.twig', array(
            'user'          => $app['authentication']->getUser(),
            'evt_mngr'      => $app['events-manager'],
            'notifications' => $app['events-manager']->list_notifications_available($app['authentication']->getUser()->get_id()),
        ));
    }

    /**
     * Update account informations
     *
     * @param  PhraseaApplication $app     A Silex application where the controller is mounted on
     * @param  Request            $request The current request
     * @return Response
     */
    public function updateAccount(PhraseaApplication $app, Request $request)
    {
        $demands = (array) $request->request->get('demand', array());

        if (0 !== count($demands)) {
            $register = new \appbox_register($app['phraseanet.appbox']);

            foreach ($demands as $baseId) {
                try {
                    $register->add_request($app['authentication']->getUser(), \collection::get_from_base_id($app, $baseId));
                    $app->addFlash('success', _('login::notification: Vos demandes ont ete prises en compte'));
                } catch (\Exception $e) {

                }
            }
        }

        $accountFields = array(
            'form_gender',
            'form_firstname',
            'form_lastname',
            'form_address',
            'form_zip',
            'form_phone',
            'form_fax',
            'form_function',
            'form_company',
            'form_activity',
            'form_geonameid',
            'form_addrFTP',
            'form_loginFTP',
            'form_pwdFTP',
            'form_destFTP',
            'form_prefixFTPfolder',
            'form_retryFTP'
        );

        if (0 === count(array_diff($accountFields, array_keys($request->request->all())))) {
            $defaultDatas = 0;

            if ($datas = (array) $request->request->get("form_defaultdataFTP", array())) {
                if (in_array('document', $datas)) {
                    $defaultDatas += 4;
                }

                if (in_array('preview', $datas)) {
                    $defaultDatas += 2;
                }

                if (in_array('caption', $datas)) {
                    $defaultDatas += 1;
                }
            }

            try {
                $app['phraseanet.appbox']->get_connection()->beginTransaction();

                $app['authentication']->getUser()->set_gender($request->request->get("form_gender"))
                    ->set_firstname($request->request->get("form_firstname"))
                    ->set_lastname($request->request->get("form_lastname"))
                    ->set_address($request->request->get("form_address"))
                    ->set_zip($request->request->get("form_zip"))
                    ->set_tel($request->request->get("form_phone"))
                    ->set_fax($request->request->get("form_fax"))
                    ->set_job($request->request->get("form_activity"))
                    ->set_company($request->request->get("form_company"))
                    ->set_position($request->request->get("form_function"))
                    ->set_geonameid($request->request->get("form_geonameid"))
                    ->set_mail_notifications((bool) $request->request->get("mail_notifications"))
                    ->set_activeftp($request->request->get("form_activeFTP"))
                    ->set_ftp_address($request->request->get("form_addrFTP"))
                    ->set_ftp_login($request->request->get("form_loginFTP"))
                    ->set_ftp_password($request->request->get("form_pwdFTP"))
                    ->set_ftp_passif($request->request->get("form_passifFTP"))
                    ->set_ftp_dir($request->request->get("form_destFTP"))
                    ->set_ftp_dir_prefix($request->request->get("form_prefixFTPfolder"))
                    ->set_defaultftpdatas($defaultDatas);

                $app->addFlash('success', _('login::notification: Changements enregistres'));
                $app['phraseanet.appbox']->get_connection()->commit();
            } catch (Exception $e) {
                $app->addFlash('error', _('forms::erreurs lors de l\'enregistrement des modifications'));
                $app['phraseanet.appbox']->get_connection()->rollBack();
            }
        }

        $requestedNotifications = (array) $request->request->get('notifications', array());

        foreach ($app['events-manager']->list_notifications_available($app['authentication']->getUser()->get_id()) as $notifications) {
            foreach ($notifications as $notification) {
                $notifId = $notification['id'];
                $notifName = sprintf('notification_%d', $notifId);

                if (isset($requestedNotifications[$notifId])) {
                    $app['authentication']->getUser()->setPrefs($notifName, '1');
                } else {
                    $app['authentication']->getUser()->setPrefs($notifName, '0');
                }
            }
        }

        return $app->redirect($app->path('account'));
    }
}