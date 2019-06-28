<?php


namespace ContacterBundle\Twig\Extension;



class TimeExtension extends  \Twig_Extension
{
   
  

 
public function get_timeago( $tptime )
{
   $str =$tptime->format('Y-m-d H:i:s');
   $ptime=strtotime($str);
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array( 
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return  $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}




   /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('time', array($this,'get_timeago')),
        );
    }






    public function getName()
    {
        return "ContacterBundle:TimeExtension";
    }
}