<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    const HTTP_OK = 200;
    const HTTP_BAD = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_SERVER_ERROR = 500;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @param array $data
     * @param int $http_code
     * return void
     */
    public function response($data = [], int $http_code = 200)
    {
        $this->output->set_status_header($http_code);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        return;
    }


    /**
     * @param array $data
     * @param int $http_code
     */
    public function response_success(array $data = [], int $http_code = 200)
    {
        $data['status'] = Test::RESPONSE_STATUS_SUCCESS;
        $this->output->set_status_header($http_code);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        return;
    }

    /**
     * @param array $data
     * @param int $http_code
     */
    public function response_info(array $data = [], int $http_code = 200)
    {
        $data['status'] = Test::RESPONSE_STATUS_INFO;
        $this->output->set_status_header($http_code);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        return;
    }

    /**
     * @param string $error_message
     * @param array $data
     * @param int $http_code
     */
    public function response_error(string $error_message = 'error_core_internal', $data = [], int $http_code = 200)
    {
        $data['status'] = Test::RESPONSE_STATUS_ERROR;
        $data['error_message'] = $error_message;
        $this->output->set_status_header($http_code);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        return;
    }

    public function __destruct()
    {

    }
}