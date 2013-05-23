<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adaptconference extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("rsvp_model");

    }

    function index()
    {
        $this->home();
    }

    function home()
    {
        $this->section='home';

        $this->load->view('rsvp/conference_header');
        $this->load->view('rsvp/conference_home');
        $this->load->view('rsvp/conference_footer');
    }

    function agenda()
    {
        $this->section='venue';
        $this->load->view('rsvp/conference_header');
        $this->load->view('rsvp/conference_agenda');
        $this->load->view('rsvp/conference_footer');
    }
    
    function archive()
    {
        $this->section='archive';
        $this->load->view('rsvp/conference_header');
        $this->load->view('rsvp/conference_archive');
        $this->load->view('rsvp/conference_footer');
    }
    
    function gallery()
    {
        $this->section='gallery';
        $this->load->view('rsvp/conference_header');
        $this->load->view('rsvp/conference_gallery');
        $this->load->view('rsvp/conference_footer');
    }
    
    function speakers()
    {
        $this->load->view('rsvp/conference_header');
                $this->load->view('rsvp/conference_speakers');
        $this->load->view('rsvp/conference_footer');

        }

    function venue()
    {
        $this->section='venue';
        $this->load->view('rsvp/conference_header');
        $this->load->view('rsvp/conference_venue');
        $this->load->view('rsvp/conference_footer');
    }

    function invite()
    {
        $this->section='invite';
        $this->load->view('rsvp/conference_header');
        $this->load->view('rsvp/conference_invite');
        $this->load->view('rsvp/conference_footer');
    }

    function insert()
    {
        $data = array(
            "first_name" => $this->input->post("first_name"),
            "last_name" => $this->input->post("last_name"),
            "email" => $this->input->post("email"),
            "company" => $this->input->post("company"),
            "job_title" => $this->input->post("job_title")
        );

        $num_rows = $this->rsvp_model->insert_data($data);
        if (0 >= $num_rows) {
            $this->load->view('rsvp/conference_header');
            $this->load->view("rsvp/error");
            $this->load->view('rsvp/conference_footer');

        } else {
            $this->load->view('rsvp/conference_header');
            $this->load->view("rsvp/done");
            $this->load->view('rsvp/conference_footer');

        }
    }
}

?>
