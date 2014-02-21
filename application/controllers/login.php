<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class Login extends CI_Controller {

    var $table = 'administrators';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('login_model');
        $this->load->library('hashpass');
        $this->output->enable_profiler(false);
    }

    function index()
    {
        $data['title'] = 'Login';
        $data['msg'] = $this->session->flashdata('error');
        $this->load->view('login/login_view', $data);
    }

    function process_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('passwd');

        //check if the user has entered a username & password else redirect back to login page
        if (empty($email) || empty($password))
        {
            $msg = 'Please enter a email and/or password';
            $this->session->set_flashdata('error', $msg);
            redirect("/login");
        }

        //if username exists then check for the details from the database
        $logininfo = $this->login_model->login($this->table, $email);

        //get hashed password from the database
        $hash = $logininfo->password;

        //check that it returns an id from the database, if empty redirect back to login home
        if (empty($logininfo->id)) {
            $msg = 'Invalid e-mail or password';
            $this->session->set_flashdata('error', $msg);
            redirect('/login');
        }

        /*
        * check if the password entered matches the hashed password from the database
        * if it matches then get user details and add them to session the redirect to cmsadmin
        * if it doesn't match then redirect with an error message back to the login page with an error
        */
        if($this->hashpass->check_password($hash, $password))
        {
            //adding userdetails to array newdata
            $newdata = array(
                'admin_id' => $logininfo->id,
                'username' => $logininfo->username,
                'firstname' => $logininfo->firstname,
                'lastname' => $logininfo->lastname,
                'email' => $logininfo->email
            );

            //add them to a new session
            $this->session->set_userdata($newdata);

            //redirect to last url or homepage
            if($this->session->userdata('redirect_to'))
            {
                $redirect_to = $this->session->userdata('redirect_to');
                redirect($redirect_to);
            }
            else
            {
                redirect('/home');
            }
        }
        else
        {
            $msg = 'Invalid email and/or password';
            $this->session->set_flashdata('error', $msg);
            redirect('/login');
        }
    }

    function logout()
    {
        $this->session->unset_userdata(
            array(
            'admin_id'=>'',
            'username'=>'',
            'firstname'=>'',
            'lastname'=>'',
            'email'=>'',
            )
        );
        $this->session->sess_destroy();
        redirect("/");
    }
}
?>
