<div class="section-box">
	<div class="section-header">approvals:</div>
	<div class="section-approval">
		<div class="approval-column" v-for="item in departmentList">
			<div class="approval-signature">[signed]</div>
			<div class="approval-department">@{{ item }}</div>
		</div>
	</div>
</div>