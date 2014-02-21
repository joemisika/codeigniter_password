<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class Administrators extends CI_Controller {

    //name of the table to be used in this controller
    var $table = 'administrators';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->library('hashpass');
        $this->output->enable_profiler(false);

        //Redirect user to this page if login had expired - store the url in a session
        if(!$this->session->userdata('admin_id'))
        {
            $this->session->set_userdata("redirect_to", '/administrators');
            redirect('/login');
        }
    }

    /**
    * Saving a new password at creation
    *
    */
    function savenew()
    {

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $hashedpass = $this->hashpass->hash_password($password);

        $dbdata = array(
            'firstname'=>$firstname,
            'lastname'=>$lastname,
            'email'=>$email,
            'username'=>$username,
            'password'=>$hashedpass,
            'createdate'=>date('c'),
            'modified'=>date('c')
            );

        $admin_id = $this->admin_model->saveinfo($this->table, $dbdata);

        //after data is saved - redirect to a success or failure page by checking if it returns an $admin_id
    }

    function edit()
    {
        //run exactly the same script as above, just update the information instead of saving it anew.
    }

}
/* End of file administrators.php */
/* Location: ./application/controllers/administrators.php */
