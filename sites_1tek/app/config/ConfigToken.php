<?php
/*******************************************************************************************************************/
/*                                              Se define la clase                                                 */
/*******************************************************************************************************************/
class ConfigToken{

    const JWT = [
        'TOKEN_AUTHENTICATION' => true, // (boolean) - enable/disable token authentication
        'SECRET_KEY'           => 'c2Q2NWZnMTZlOHJnczZkZnY1MTZzZDVmdjFzNmRmNXYxNmFlZjVnNDE2NGc2ZThnYXc2ZGY1MWEyMQ', // (string) secret key for token encryption
        'TIME_TO_LIVE'         => 86400, // (int) seconds  - token life time
    ];

    const ENCODE_KEYS = [
        'KEY_1' => 'akZ6Tm1SbU5YWXhObUZsWmpWbk5ERTJOR2MyWlRobllYYzJaR1kxTVdFeU1R',
    ];

}