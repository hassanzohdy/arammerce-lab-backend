<?php
namespace HZ\Laravel\Organizer\App\Macros\Http;

use Str;

class Request
{
    /**
     * If the authorization argument is auto, then it will be auto detect the 
     * value of the passed Authorization header
     * 
     * @const bool
     */
    const AUTO = true;

    /**
     * Get request referer
     * 
     * @return string
     */
    public function referer()
    {
        return function () {
            return $this->server('HTTP_REFERER');
        };
    }

    /**
     * Get request uri
     * 
     * @return string
     */
    public function uri()
    {
        return function () {
            $script = str_replace('/index.php', '', $this->server('SCRIPT_NAME'));

            return Str::removeFirst($script, $this->server('REQUEST_URI'));
        };
    }

    /**
     * Get the value of the Authorization header
     * 
     * @param  string|bool $authorizationType
     * @return string|void
     */
    public function authorization()
    {
        return function () {
            return $this->server('HTTP_AUTHORIZATION') ?: $this->server('REDIRECT_HTTP_AUTHORIZATION');
        };
    }

    /**
     * Get authorization value only
     * If the authorization argument is auto, then it will be auto detect the 
     * value of the passed Authorization header
     * 
     * If the passed argument is set false, then the whole value will be returned
     * 
     * @param  string|bool $authorizationType
     * @return string|void
     */
    public function authorizationValue()
    {
        return function ($authorizationType = Request::AUTO) {
            $authorization = $this->authorization();

            if (! $authorization) return;
            list($type, $value) = explode(' ', $authorization);

            if ($authorizationType === Request::AUTO) {
                return $value;
            }

            if ($authorizationType === $type) return $value;
        };
    }
}
