<?php 

	class Product_model extends CI_Model {

        public function get_entries()
        {
                $query = $this->db->get('product');
                if (count( $query->result() ) > 0) {
                	return $query->result();
                }
        }

        public function insert_entry($data)
        {
            return $this->db->insert('product', $data);
        }

        public function delete_entry($id){
        	return $this->db->delete('product', array('id' => $id));
        }

        public function edit_entry($id){
        	$this->db->select("*");
        	$this->db->from("product");
        	$this->db->where("id", $id);
        	$query = $this->db->get();
        	if (count($query->result()) > 0) {
        		return $query->row();
        	}
        }

        public function update_entry($data)
        {
            return $this->db->update('product', $data, array('id' => $data['id']));
        }

}