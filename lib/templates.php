<?php
Twig_Autoloader::register();

class TwigObj
{
  private $twig_loader;
  private $twig;
  private $templates;
  private $mode;
  private $user;

  public function init($mode, $user) {
    $this->twig_loader = new Twig_Loader_Filesystem(dirname(__FILE__).'/../templates');
    $this->mode = $mode;

    if ($this->mode == "DEBUG") {
      $this->twig = new Twig_Environment($this->twig_loader,
      array('debug' => true));
      $this->twig->addExtension(new Twig_Extension_Debug());
    } else {
      $this->twig = new Twig_Environment(
        $this->twig_loader,
        array('cache' => dirname(__FILE__).'/../cache')
      );
    }

    //Load filters;
    $this->loadFilters();
    $this->templates = [];
    $this->user = $user;
  }

  function loadFilters() {

    $asset = new Twig_SimpleFilter('asset', function($url) {
      return '/mirror/res/' . $url;
    });
    $page = new Twig_SimpleFilter('page', function($url, $addData = null) {
      $sep = (strpos($url, '?') !== false)? '&' : '?';
      if ($addData !== null) foreach($addData as $k => $v) {
        $url .= $sep . $k . '=' . $v;
        $sep = '&';
      }
      return '/mirror/pages/' . $url;
    });
    $dist = new Twig_SimpleFilter('dist', function($url) {
      return '/mirror/dist/' . $url;
    });

    $this->twig->addFilter($asset);
    $this->twig->addFilter($page);
    $this->twig->addFilter($dist);
  }

  function render($name, $data = array()) {
    $data['user'] = $this->user;

    if (!array_key_exists($name, $this->templates)) {
      $template
        = $this->templates[$name]
        = $this->twig->loadTemplate($name);
    } else {
      $template = $this->templates[$name];
    }
    echo $template->render($data);
  }

  function close() {
    //Nothing much to do here!
  }
}
$Twig = new TwigObj();
