<?php
class post extends Controller {
	private $giraffe;
	private $data = array();
	public function __construct() {
		parent::__construct();
		global $giraffe;
		$this->giraffe = $giraffe;
		$this->data["header_inner"] = "";
		
		// We assume that they have not changed the file path.
		$this->load->model("Cms","cms",PATH."/../site/models/");
	}

	public function index() {
		$this->data["site_title"] = "Post";
		$this->data["post_list"] = $this->cms->get_post_list();
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
		$this->load->view('post',$this->data);
	}
	public function create() {
		$post_id = $this->cms->create_post_empty($_SESSION["auth_id"]);
		$this->giraffe->request_handler->forwardTo("post/edit/".$post_id);
	}
	
	public function delete($id = "") {
		if(isset($id) && is_numeric($id) && $this->giraffe->auth->isLoggedIn()) {
			$this->cms->delete_post($id);
			$this->giraffe->request_handler->forwardTo("post/");
		}
	}
	
	public function edit($id = "") {
		if(isset($_POST["id"]) && is_numeric($_POST["id"])) {
			$this->cms->update_post($_POST["id"],$_POST["title"],$_POST["slug"],$_POST["content"],$_POST["meta_description"],$_POST["meta_keywords"]);
			$this->giraffe->request_handler->forwardTo("post/edit/".$_POST["id"]);
		}
		$this->data["post"] = $this->cms->get_post_with_id($id);
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
 

		$this->data["site_title"] = "Create new post";
		$this->load->view('post_create',$this->data);
	}
}
?>