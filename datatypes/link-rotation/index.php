<?php
class qodyDatatype_RedirectorLinkRotation extends QodyDataType
{
	function __construct()
    {
        $this->SetOwner( func_get_args() );
		$this->m_raw_file = __FILE__;
		
		$this->m_table_slug = 'rotations';
		
		add_action( 'template_redirect', array( $this, 'CheckForRotationLink' ) );
		
        parent::__construct();
    }
	
	function CheckForRotationLink()
	{
		if( isset( $_GET['qrlrid'] ) )
		{
			$url = $this->Rotate( $_GET['qrlrid'] );
			
			if( !$url )
				return;
			
			header( "Location: ".$url );
			exit;
		}
	}
	
	function FetchLinks( $post_id )
	{
		$custom = $this->get_datatype_custom( $post_id );
		
		$data = array();
		
		if( !$custom['destination_url'] )
			return $data;
		
		foreach( $custom['destination_url'] as $key => $value )
		{
			if( !trim($value) )
				continue;
				
			$link = array();
			$link['url'] = $value;
			$link['weight'] = $custom['weight'][ $key ];
			$link['hits'] = $custom['hits'][ $key ];
			$link['index'] = $key;
			
			$data[] = $link;
		}
		
		return $data;
	}
	
	function GetRotationLink( $rotation_id )
	{
		if( !$rotation_id )
			return;
		
		$url = get_bloginfo('url').'?qrlrid='.$rotation_id;
		
		return $url;
	}
	
	function SortByHits( $item1, $item2 )
	{		
		if( $item1['hits'] == $item2['hits'] )
			return 0;
		
		return $item1['hits'] < $item2['hits'] ? -1 : 1;
	}
	
	function Rotate( $rotation_id )
	{
		if( !$rotation_id )
			return;
		
		$data = $this->FetchLinks( $rotation_id );
		
		if( !$data )
			return;
			
		$url = '';
		$custom = $this->get_datatype_custom( $rotation_id );
		
		switch( $custom['rotation_type'] )
		{
			case 'least_hit':
				
				usort( $data, array( $this, 'SortByHits' ) );
				
				$link = $data[0];
				
				break;
			
			case 'sequential':
				
				$last_hit = $custom['last_hit'];
				
				if( !$last_hit )
					$last_hit = 0;
				
				foreach( $data as $key => $value )
				{
					if( count( $data ) == 1 )
					{
						$link = $value;
						break;
					}
					
					// if the last hit was at or before this link, skip it
					if( $value['index'] <= $last_hit )
						continue;
					
					// the next one in theory should be our turn, unless we were on the last one
					$link = $value;
					break;
				}
				
				// restart at the beginning if we couldn't find a next link
				if( !$link )
					$link = $data[0];
				
				break;
			
			case 'weighted':
				
				$players = array();
				$score_so_far = 0;
				
				// randomize it for good measure
				shuffle( $data );
				
				// figure out which users will participate in the weight contest
				foreach( $data as $key => $value )
				{
					if( !$value['weight'] || $value['weight'] <= 0 )
						continue;
					
					$score_so_far += $value['weight'];
					
					$player = array();
					$player['data'] = $value;
					$player['score'] = $score_so_far;
					$players[] = $player;
				}
				
				$total_score = $score_so_far;
				
				// if we have players, roll a random number based on their total score & see who wins
				if( $players )
				{
					$winning_number = rand() % $total_score;
					
					foreach( $players as $key => $value )
					{
						if( $winning_number < $value['score'] )
						{
							$link = $value['data'];
							break;
						}
					}
				}
				
				break;
				
			case 'random':
			default:
				
				shuffle( $data );
				
				$link = $data[0];
				break;
		}
		
		if( $link )
		{
			$custom['hits'][ $link['index'] ] += 1;
			
			$this->update_datatype_meta( $rotation_id, 'hits', $custom['hits'] );
			$this->update_datatype_meta( $rotation_id, 'last_hit', $link['index'] );
			
			return $link['url'];
		}
	}
}


















?>