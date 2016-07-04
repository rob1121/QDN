<div class="section-box">

    <div class="section-approval">
        <div class="title">approvals:</div>

        <div class="signature-group">
            <div class="approval-column" v-for="item in departmentList">
                <div class="approval-signature">approver signature</div>
                <div class="approval-department">@{{ item }}</div>
            </div>
        </div>
	</div>
</div>