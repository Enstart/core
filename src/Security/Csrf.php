<?php namespace Enstart\Security;

use Enstart\Http\SessionInterface;

class Csrf extends \Maer\Security\Csrf\Csrf implements CsrfInterface
{
    /**
     * The default token name if user omit the name from the requests
     * @var string
     */
    protected $defaultName = 'defaultToken';

    /**
     * Key name for the session with the token collection
     * @var string
     */
    protected $key         = 'enstart_csrf_tokens';

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        // Only loaded so the session will be started.
        $this->session = $session;
    }
}
