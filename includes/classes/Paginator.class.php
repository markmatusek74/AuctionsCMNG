<?php
/**
 * Created by PhpStorm.
 * User: markmatusek
 * Date: Jan 9, 2011
 * Time: 9:01:14 PM
 * To change this template use File | Settings | File Templates.
 */

class Paginator {

    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;

    public function __construct( $conn, $query ) {

        $this->_conn = $conn;
        $this->_query = $query;

        $rs= $this->_conn->query( $this->_query );
        $this->_total = $rs->num_rows;

    }

    public function getData( $limit = 10, $page = 1 ) {

        $this->_limit   = $limit;
        $this->_page    = $page;

        if ( $this->_limit == 'all' ) {
            $query      = $this->_query;
        } else {
            $query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
     //   print $query . "<br />";
        $rs             = $this->_conn->query( $query );

        while ( $row = $rs->fetch_assoc() ) {
            $results[]  = $row;
        }

        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $results;

        return $result;
    }

    public function createLinks( $links, $list_class, $pageName ) {
        if ( $this->_limit == 'all' ) {
            return '';
        }

        $last       = ceil( $this->_total / $this->_limit );

        $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

        $html       = '<ul class="' . $list_class . '">';

        $class      = ( $this->_page == 1 ) ? "disabled" : "";
        $html       .= '<li class="' . $class . '"><a href="' . $pageName . '?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

        if ( $start > 1 ) {
            if (strpos($pageName,"?") !== FALSE)
            {
                $html   .= '<li><a href="' . $pageName . '&limit=' . $this->_limit . '&page=1">1</a></li>';
            }
            else
            {
                $html   .= '<li><a href="' . $pageName . '?limit=' . $this->_limit . '&page=1">1</a></li>';

            }

//            $html   .= '<li><a href="' . $pageName . '?limit=' . $this->_limit . '&page=1">1</a></li>';
            $html   .= '<li class="disabled"><span>...</span></li>';
        }

        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->_page == $i ) ? "active" : "";
            if (strpos($pageName,"?") !== FALSE)
            {
                $html   .= '<li class="' . $class . '"><a href="' . $pageName . '&limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
            }
            else
            {
                $html   .= '<li class="' . $class . '"><a href="' . $pageName . '?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';

            }

          //  $html   .= '<li class="' . $class . '"><a href="' . $pageName . '?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ( $end < $last ) {
            $html   .= '<li class="disabled"><span>...</span></li>';
            if (strpos($pageName,"?") !== FALSE)
            {
                $html   .= '<li><a href="' . $pageName . '&limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
            }
            else
            {
                $html   .= '<li><a href="' . $pageName . '?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
            }
        }

        $class      = ( $this->_page == $last ) ? "disabled" : "";
        if (strpos($pageName,"?") !== FALSE)
        {
            $html       .= '<li class="' . $class . '"><a href="' . $pageName . '&limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
        }
        else
        {
            $html       .= '<li class="' . $class . '"><a href="' . $pageName . '?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
        }


        $html       .= '</ul>';

        return $html;
    }
}
?>