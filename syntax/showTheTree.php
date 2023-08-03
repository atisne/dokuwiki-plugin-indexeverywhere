<?php
/**
 * DokuWiki Plugin indexeverywhere (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Sascha Zantis <sascha.zantis@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_indexeverywhere_showTheTree extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'container';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'normal';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 99;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~INDEXEVERYWHERE~~',$mode,'plugin_indexeverywhere_showTheTree');
    }

    /**
     * Handle matches of the indexeverywhere syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){
        $data = array();
        return $data;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;
        global $conf;
        global $ID;
        $ns = dirname(str_replace(':','/',$ID));
        if($ns == '.') $ns ='';
        $ns  = utf8_encodeFN(str_replace(':','/',$ns));

        $index = '<div id="index__tree" class="indexeverywhere">';
        $data = array();
        $index .= search($data,$conf['datadir'],'search_index',array('ns' => $ns));
        $index .= html_buildlist($data,'idx','html_list_index','html_li_index');

        $index .= '</div>';
        $renderer->doc .=  $index;

        return true;
    }
}

// vim:ts=4:sw=4:et:
