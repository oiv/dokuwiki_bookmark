<?php
/**
 * Plugin bookmark: Creates a bookmark to your document.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Otto Vainio <bookmark.plugin@valjakko.net>
 */
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_bookmark extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Otto Vainio',
            'email'  => 'plugins@valjakko.net',
            'date'   => '2020-07-14',
            'name'   => 'Bookmark plugin',
            'desc'   => 'a bookmark <a name=\'name\'></a>',
            'url'    => 'http://www.dokuwiki.org/plugin:bookmark',
        );
    }
 
    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }
 
    function getSort(){ return 357; }
 
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<BOOKMARK:\w+>',$mode,'plugin_bookmark');
    }
 
 
    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){
        $match = substr($match,10,-1); //strip <BOOKMARK: from start and > from end
        return array(strtolower($match));
    }
 
    /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml'){
            $renderer->doc .= '<a name="' . $data[0] . '" id="' . $data[0]. '"></a>';
            return true;
        }
        return false;
    }
}
?>
