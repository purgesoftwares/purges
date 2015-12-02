<!-- Header Row Modal -->
<div class="modal fade hbModal" id="headerRow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Header Row</h4>
			</div>
			<div class="modal-body">
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Row Style
						</p>
						<span class="settingNote">Note: For the small style, logo builder's style won't work.</span>
					</div>
					<div class="col-sm-5">
						<select>
							<option>Large</option><option>Small</option>
						</select>
					</div>
				</div>
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Background color
						</p>
					</div>
					<div class="col-sm-5">
						color picker here
					</div>
				</div>
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Content color
						</p>
					</div>
					<div class="col-sm-5">
						<select>
							<option>Light Content</option><option>Dark Content</option>
						</select>
					</div>
				</div>
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Fixed row
						</p>
					</div>
					<div class="col-sm-5">
						<input id="fixedRow" type="checkbox"/>
					</div>
				</div>
				<div class="modalRow row clearfix">
					<div class="col-sm-7">
						<p class="settingName">
							Just Fixed row
						</p>
						<span class="settingNote">The row will appear on top of the page when scrolling but it'll be invisible in the header.</span>
					</div>
					<div class="col-sm-5">
						<input id="justFixedRow" type="checkbox"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<p>
					Add custom class
				</p>
				<input id="customClass" type="text"/>
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					Done
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Header Row Modal End -->