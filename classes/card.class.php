<?php 


class Card{
    protected $card_name;
    protected $card_description;
    protected $card_image;
    protected $card_price;
    protected $card_time;
    protected $price_up;
    protected $time_up;
    protected $active;

    public function __construct($n,$d,$i,$p,$th,$tm,$ts,$pu,$tu,$a)
    {
        $this->card_name = $n;
        $this->card_description = $d;
        $this->card_image= $i;
        $this->card_price=$p;
        $this->card_time_hour=$th;
        $this->card_time_minute=$tm;
        $this->card_time_seconde=$ts;
        $this->price_up=$pu;
        $this->time_up=$tu;
        $this->active=$a;
    }

    public function getName()
    {
        return $this->card_name;
    }

    public function getDescription()
    {
        return $this->card_description;
    }

    public function getImage()
    {
        return $this->card_image;
    }

    public function getPrice()
    {
        return $this->card_price;
    }

    public function getHour()
    {
        return $this->card_time_hour;
    }

    public function getMinute()
    {
        return $this->card_time_minute;
    }

    public function getSeconde()
    {
        return $this->card_time_seconde;
    }

    public function getPriceUp()
    {
        return $this->price_up;
    }

    public function getTimeUp()
    {
        return $this->time_up;
    }

    public function getActive(){
        return $this->active;
    }
}


?>