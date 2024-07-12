<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;


class CourierUtilities 
{
    public function __construct(private Session $session) {
    }

    public function makeTransitTimes(): Entities\TransitTimes
    {
        return new Entities\TransitTimes();
    }

    public function transitTimes(Entities\TransitTimes $transitTimes): Responses\TransitTimes
    { 
        return (new Utilities\TransitTimes($this->session))->transitTimes($transitTimes);
    } 

    public function makeCosts(): Entities\Costs
    {
        return new Entities\Costs();
    }

    public function costs(Entities\Costs $costs): Responses\Costs
    { 
        return (new Utilities\Costs($this->session))->costs($costs);
    } 

    public function makeRating(): Entities\Rating
    {
        return new Entities\Rating();
    }

    public function rating(Entities\Rating $rating): Responses\Rating
    { 
        return (new Utilities\Rating($this->session))->rating($rating);
    } 

}
