<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Template class
 *
 * @author Zack Hovatter
 */
class Template
{
	private $_CI;
	
	private $_base_title;
	private $_body_classes = array();
	private $_javascripts = array();
	private $_meta_tags = array();
	private $_stylesheets = array();
	private $_template_name;
	private $_template_data;
	private $_title_segments = array();
	private $_title_separator;
	
	public function __construct()
	{
		$this->_CI = &get_instance();
		
		$this->_CI->config->load('template', TRUE);
		$config_data = $this->_CI->config->item('template');
		
		foreach ($config_data as $key => $val)
		{
			$this->$key = $val;
		}
	}
	
	/**
	 * Adds a class to the body
	 *
	 * @param string body_class
	 * @author Zack Hovatter
	 */
	public function add_body_class($body_class)
	{
		$this->_body_classes[] = $body_class;
		return $this;
	}
	
	/**
	 * Add a javascript include. If you specify external as true it will
	 * use a URL instead of looking in your assets folder.
	 *
	 * @param string $javascript_name
	 * @param bool $external 
	 */
	public function add_javascript($javascript_name, $external = FALSE)
	{
		$this->_javascripts[] = $external ? $javascript_name : base_url() . $this->_assets_dir . 'js/' . $javascript_name;
		return $this;
	}
	
	/**
	 * Add a meta tag
	 *
	 * @param string $name 
	 * @param string $content 
	 */
	public function add_meta_tag($name, $content)
	{
		$this->_meta_tags[] = '<meta name="' . $name . '" content="' . $content . '" />';
		return $this;
	}
	
	/**
	 * Add a stylesheet include. If you specify external as true it will
	 * use a URL instead of looking in your assets folder.
	 *
	 * @param string $stylesheet_name 
	 * @param string $media 
	 * @param bool $external 
	 */
	public function add_stylesheet($stylesheet_name, $media = 'screen', $external = FALSE)
	{
		$this->_stylesheets[] = array(
			'href' => $external ? $stylesheet_name : base_url() . $this->_assets_dir . 'css/' . $stylesheet_name,
			'media' => $media
		);
		return $this;
	}
	
	/**
	 * Add a title segment
	 *
	 * @param string $segment 
	 */
	public function add_title_segment($segment)
	{
		$this->_title_segments[] = $segment;
		return $this;
	}
	
	/**
	 * Build out the view
	 *
	 * @param string $view_name 
	 * @param array $view_data 
	 */
	public function build($view_name, $view_data = array())
	{
		$this->_template_data['meta_tags'] = implode("\r\n", $this->_meta_tags);
		
		$this->_template_data['title'] = $this->_base_title;
		if (count($this->_title_segments) > 0)
		{
			$this->_template_data['title'] .= $this->_title_separator . implode($this->_title_separator, $this->_title_segments);
		}
		
		$this->_template_data['stylesheets'] = '';
		foreach ($this->_stylesheets as $stylesheet)
		{
			$this->_template_data['stylesheets'] .= '<link href="' . $stylesheet['href'] . '" media="' . $stylesheet['media'] . '" rel="stylesheet" type="text/css" />' . "\r\n";
		}
		
		$this->_template_data['body_class'] = implode(' ', $this->_body_classes);
		$this->_template_data['content'] = $this->_CI->load->view($view_name, $view_data, TRUE);
		
		$this->_template_data['javascripts'] = '';
		foreach ($this->_javascripts as $javascript)
		{
			$this->_template_data['javascripts'] .= '<script src="' . $javascript . '" type="text/javascript"></script>' . "\r\n";
		}
		
		$this->_CI->load->view($this->_template_name, $this->_template_data);
	}
	
	/**
	 * Set the base title
	 *
	 * @param string $base_title 
	 */
	public function set_base_title($base_title)
	{
		$this->_base_title = $base_title;
		return $this;
	}
	
	/**
	 * Set the template file name
	 *
	 * @param string $template_name 
	 */
	public function set_template($template_name)
	{
		$this->_template_name = $template_name;
		return $this;
	}
	
	/**
	 * Set the title separator
	 *
	 * @param string $title_separator 
	 */
	public function set_title_separator($title_separator)
	{
		$this->_title_separator = $title_separator;
		return $this;
	}
	
	/**
	 * Allows you to set a custom variable to be accessed in your template file.
	 *
	 * @param string $name 
	 * @param mixed $data 
	 */
	public function set_variable($name, $data)
	{
		$this->_template_data[$name] = $data;
		return $this;
	}
}