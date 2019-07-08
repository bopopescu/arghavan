@extends('layouts.app')

@section('content')
<div id="app">
  <div class="btn-group"
    data-toggle="buttons">

    <button type="button"
      @click="selectFinger(finger)"
      class="btn btn-lg btn-round btn-default"
      :class="{ 'btn-primary': finger_index == finger.index, }"
      v-for="finger in fingers_right">

      @{{ finger.name }}

        <div class="ripple-container"></div>
    </button>
  </div>

/////////////////

  <div class="btn-group"
    data-toggle="buttons">

    <button type="button"
      @click="selectFinger(finger)"
      class="btn btn-lg btn-round btn-default"
      :class="{ 'btn-primary': finger_index == finger.index, }"
      v-for="finger in fingers_left">

      @{{ finger.name }}

        <div class="ripple-container"></div>
    </button>
  </div>
</div>
@endsection

@section('scripts')

<script>
  new Vue({
    el: '#app',
    data: {
      fingers_right: [
        {index: 0, name: 'کوچک'},
        {index: 1, name: 'f 1'},
        {index: 2, name: 'f 2'},
        {index: 3, name: 'f 3'},
        {index: 4, name: 'f 4'},
      ],
      fingers_left: [
        {index: 5, name: 'f 5'},
        {index: 6, name: 'f 6'},
        {index: 7, name: 'f 7'},
        {index: 8, name: 'f 8'},
        {index: 9, name: 'f 9'},
      ],
      finger_index: 0,
    },

    methods:
    {
        selectFinger(finger){
          this.finger_index = finger.index;
        }
    }
  })
</script>

@endsection

