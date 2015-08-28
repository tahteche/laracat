<?php
  class Cat extends Eloquent
  {
    protected $fillable = ['name', 'date_of_birth', 'breed_id'];
    public function breed()
    {
      return $this->belongsTo('Breed');
    }

    // public function getDates() {
    // return array('date_of_birth', 'created_at', 'updated_at');
    // }

    public function owner(){
      return $this->belongsTo('User');
    }

    public function isOwnedBy(User $user){
      return $this->owner === $user->id;
    }
  }