<div class="section-box">
	<h1>quality deviation notice</h1>
	<div class="section-details">
		<div class="section-info">
			<div class="col">
				<div class="info-group section1" v-for="section in section1">
					<div class="name">@{{ section.name }}:</div>
					<div class="data">@{{ section.value }}</div>
				</div>
			</div>

			<div class="col">
				<div class="info-group section2"  v-for="section in section2">
					<div class="name">@{{ section.name }}:</div>
					<div class="data">@{{ section.value }}</div>
				</div>
			</div>

			<div class="col">
				<div class="info-group section3"  v-for="section in section3">
					<div class="name">@{{ section.name }}:</div>
					<div class="data">@{{ section.value }}</div>
				</div>
			</div>
		</div>
		<textarea class="description" placeholder="Input details"></textarea>
	</div>
</div>