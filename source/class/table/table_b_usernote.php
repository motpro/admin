<?php

/**
 *      [mot!] (C)2001-2099 36lean Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_b_usernote extends discuz_table {

	private $_jointable;

	public function __construct () {
		$this->_table = 'b_usernote';
		$this->_jointable = 'b_lesson_pages';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function setnote( $data) {

		$tmp = cutstr( $data['notetext'] , 15 , '');

		$exi = DB::fetch_first(' select id from '.DB::table( $this->_table).' where notetext like \''.$tmp.'%\' and uid = '.$data['uid']);

		if( isset( $exi['id'])) return 0;

		$id = DB::query( 'insert into '.DB::table( $this->_table).'( uid, pageid,notetext,setdate) values( '.$data['uid'].', '.$data['pageid'].' , \''.$data['notetext'].'\' , \''.$data['setdate'].'\')' );

		return array('id'=> $id,'text'=>$tmp);
	}

	public function getnote( $data) {
		return DB::fetch_all('select id,notetext from '.DB::table( $this->_table).' where uid = '.$data['uid'].' and pageid = '.$data['pageid'].' order by id desc limit '.$data['sum']);
	}

	public function get_notes_by_uid( $uid) {
		return DB::fetch_all('select n.notetext, n.setdate, n.id, n.pageid, p.title from '.DB::table( $this->_jointable).' as p left join '.DB::table( $this->_table).' as n on p.id =  n.pageid where n.uid = '.$uid.' order by id desc');
	}

	public function get_user_note_by_id( $id , $uid) {
		return DB::fetch_first('select n.id,n.notetext,n.pageid,p.title from '.DB::table( $this->_table).' as n left join '.DB::table( $this->_jointable).' as p on n.pageid = p.id where n.uid = '.$uid.' and n.id = '.$id);
	}

	public function update_note_by_id( $notetext , $id , $uid) {
		return DB::query('update '.DB::table( $this->_table).' set notetext = \''.$notetext.'\' where uid = '.$uid.' and id = '.$id);
	}

	public function delete_note_by_id( $id , $uid) {
		return DB::query('delete from '.DB::table( $this->_table).' where uid = '.$uid.' and id = '.$id);
	}
}