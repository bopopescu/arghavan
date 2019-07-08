<div class="form-horizontal f-BYekan pad-all-1em pad-rem-top"
      id="fingerPrintForm">
  <div class="card">
    <div class="card-header card-header-icon" data-background-color="rose">
      ثبت اثر انگشت
            {{-- @{{ tempRecord.user.code }} --}}
    </div>

    {{-- Card Content --}}
    <div class="card-content f-BYekan">
      <h3 class="card-title f-BYekan">
        <span class="pull-left">
          <input type="button"
                  value="انصراف"
                  class="btn btn-fill btn-default"
                  @click.prevent="registerCancel">
          </span>
      </h3>

      <form class="pd-top-35em pd-bottom-2em" data-vv-scope ="FingerPrintScope">
        <div class="col-sm-12 col-md-8 col-lg-offset-2 col-12 mr-auto ml-auto">
          <div class="card-body">
            <div class="row justify-content-center">

              <div class="col-sm-10">
                <!-- Code field -->
                <div class="row">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">account_box</i>
                    </span>

                    <div class="form-group label-floating">
                      <label class="control-label">شماره کاربری</label>
                      <input name="code"
                              disabled
                              type="text"
                              class="form-control"
                              v-model="tempRecord.user.code">
                    </div>
                  </div>
                </div>
                {{-- /Code Field --}}

                <!-- Name and Lastname field -->
                <div class="row">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">face</i>
                    </span>
                    <div class="form-group label-floating">
                      <label class="control-label">نام و نام خانوادگی</label>
                      <input name="code"
                              disabled
                              type="text"
                              class="form-control"
                              v-model="tempRecordPeopleFullName">
                    </div>
                  </div>
                </div>
                {{-- / Name and Lastname Field --}}

                {{-- Finger Right --}}
                <div class="row text-center">
                  <div class="btn-group"
                      data-toggle="buttons">

                    <button type="button"
                          class="col-md-2 col-sm-6 col-xs-12 btn btn-lg btn-round btn-info">
                        &nbsp
                      <div class="ripple-container"></div>
                    </button>

                    <button type="button"
                            @click="selectFinger(finger)"
                            class="col-md-2 col-sm-6 col-xs-12 btn btn-lg btn-round btn-default"
                            :class="{ 'btn-primary': finger_index == finger.index, }"
                            v-for="finger in fingers_right">

                        @{{ finger.name }}

                      <div class="ripple-container"></div>
                    </button>
                  </div>
                </div>

                {{-- Finger Left --}}
                <div class="row text-center">
                  <div class="btn-group"
                      data-toggle="buttons">

                    <button type="button"
                          @click="selectFinger(finger)"
                          class="col-md-2 col-sm-6 col-xs-12 btn btn-lg btn-round btn-default"
                          :class="{ 'btn-primary': finger_index == finger.index, }"
                          v-for="finger in fingers_left">
                        @{{ finger.name }}
                      <div class="ripple-container"></div>
                    </button>

                    <button type="button"
                          class="col-md-2 col-sm-6 col-xs-12 btn btn-lg btn-round btn-info">
                          &nbsp
                      <div class="ripple-container"></div>
                    </button>

                  </div>
                </div>
                <hr>

                <div class="row text-center">
                  <input type="submit"
                    value="ثبت اثرانگشت"
                    class="btn btn-fill btn-rose"
                    @click.prevent="enroll()">
                    <input type="button"
                            value="شناسایی اثرانگشت"
                            class="btn btn-fill btn-rose"
                            @click.prevent="identify()">
                </div>
              </div>

              <div class="col-sm-2">
                 <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                        <img :src="tempRecord.people.pictureUrl" alt="...">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </form>
    </div>
    {{-- /Card Content --}}
  </div>
</div>


