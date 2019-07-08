<div class="form-horizontal f-BYekan pad-all-1em pad-rem-top" id="registerForm">
	<div class="card">

		{{-- Card Header --}}
		<div class="card-header card-header-icon" data-background-color="rose">
			@{{ tempRecord.name }}
     </div>
     {{-- /Card Header --}}

     {{-- Card Content --}}
     <div class="card-content f-BYekan">
     	<h3 class="card-title f-BYekan">

     	</h3>

     	<form class="pd-top-35em pd-bottom-2em">

               <div class = "input-group" :class="{'has-error' :errors.has('allSelect')}">
                    <div class="togglebutton">
                        <label>
                            <input class="form-check-input" type="checkbox" v-model="toggleAllBoolean"
                            name="myCheckbox" id ="myCheckbox">
                            انتخاب همه
                        </label>
                    </div>
               </div>

     		{{-- List Permissions --}}
     		<div v-for = "permission in permissions" class="form-check col-md-6">
     			<label :title="permission.description" class="upper-case">
     				<input class="form-check-input permission-flag"
                        {{-- v-model="permission.checked" --}}
                        type="checkbox"
                        name="rolePermissions">
     				@{{ permission.name }}
     			</label>
     			<span class="form-check-sign">
     				<span class="check"></span>
     			</span>
     		</div>
     		{{-- /List Permissions --}}

            <span class="pull-left">
                <input type="submit" value="ذخیره" class="btn btn-fill btn-rose" @click.prevent="savePermissionRecord">
                <input type="button" value="انصراف" class="btn btn-fill btn-default" @click.prevent="registerCancel">
            </span>
     	</form>

     </div>
     {{-- /Card Content --}}

 </div>
</div>


