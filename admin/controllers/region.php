<?php
class region extends Controller {
	private $giraffe;
	private $data = array();
	public function __construct() {
		parent::__construct();
		global $giraffe;
		$this->giraffe = $giraffe;
		$this->data["header_inner"] = "";
		
		// We assume that they have not changed the file path.
		$this->load->model("Cms","cms",PATH."/../site/models/");
		
		$this->load->model("Admin","admin");
		// We are pretty doomed if user changes the default site name
		$this->admin->set_site_name("default");
		$this->data["admin"] = $this->admin;
	}

	public function index() {
		$this->data["site_title"] = "Regions";
		$this->data["region_list"] = $this->admin->get_region_list();
		$url = get_siteinfo("theme_url");
		$this->data["header_inner"] = <<<EOD
		<script type="text/javascript" src="$url/includes/jquery.tablesorter.min.js"></script> 
		<script type="text/javascript">
			$(document).ready(function()  { 
				$("#post_table").tablesorter(); 
			} 
			); 
		</script>

EOD;
		$this->load->view('region',$this->data);
	}
	public function create() {
		$region_id = $this->admin->create_region_empty("default");
		$this->giraffe->request_handler->forwardTo("region/edit/".$region_id);
	}
	
	public function delete($id = "") {
		if(isset($id) && is_numeric($id) && $this->giraffe->auth->isLoggedIn()) {
			$this->admin->delete_region($id);
			$this->giraffe->request_handler->forwardTo("region");
		}
	}

	public function edit($id = "") {
		if(isset($_POST["id"]) && is_numeric($_POST["id"])) {
			$this->admin->update_region($_POST["id"],$_POST["site"],$_POST["name"],$_POST["content"]);
			$this->giraffe->request_handler->forwardTo("region/edit/".$_POST["id"]);
		}
		$this->data["region"] = $this->admin->get_region_with_id($id);
		$url = get_siteinfo("url");
		$this->data["header_inner"] = <<<EOD
<script type="text/javascript" src="$url/themes/admin/includes/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
EOD;
 

		$this->data["site_title"] = "Edit region";
		$this->load->view('region_edit',$this->data);
	}
}
?>