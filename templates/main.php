<?php
\OCP\Util::addScript('weather', 'angular/angular.min');
\OCP\Util::addScript('weather', 'public/app');
\OCP\Util::addStyle('weather', 'style');
?>

<div class="ng-scope" id="app" ng-app="Weather" ng-controller="WeatherController">
	<div id="city-list-left">
		<ul class="city-list">
			<li ng-repeat="city in cities" class="city-list-item {{ city.id == selectedCityId ? 'selected' : ''}}">
				<a href="#" ng-click="loadCity(city);">{{ city.name }}</a>
				<div class="icon-delete svn delete action" ng-click="deleteCity(city);"></div>
			</li>
			<li>
				<a href="#" ng-click="showAddCity = true;">Add a city...</a>
				<div ng-show="showAddCity == true" id="create-city">
					<h1>Add city</h1>
					<hr>
					<h2>City name</h2>
					<span class="city-form-error" ng-show="addCityError != ''">{{ addCityError }}</span>
					<form novalidate>
						<input type="textbox" ng-model="city.name"/>
						<input type="submit" value="Add" ng-click="addCity(city);"/>
						<input type="button" value="Cancel" ng-click="showAddCity = false;"/>
					</form>
				</div>
			</li>
		</ul>
		<div id="app-settings" class="ng-scope">
			<div id="app-settings-header">
				<button name="app settings" class="settings-button" data-apps-slide-toggle="#app-settings-content">Settings</button>
			</div>
			<div style="display: none;" id="app-settings-content">
				<h2>OpenWeatherMap API Key</h2>
				<input type="text" name="apikey" ng-change="modifyAPIKey()" ng-model="apiKey" ng-model-options="{debounce:1000}" />
				<h2>Metric</h2>
				<select name="metric" ng-change="modifyMetric()" ng-model="metric">
					<option value="metric">°C</option>
					<option value="kelvin">°K</option>
					<option value="imperial">°F</option>
				</select>
			</div>
		</div>
	</div>
	<div id="city-right" ng-show="cityLoadError != ''">
		<span class="city-load-error">{{ cityLoadError }}</span>
	</div>
	<div id="city-right" ng-show="currentCity != null" style="background-image: url('{{ owncloudAppImgPath }}/img/{{ currentCity.image }}');">
		<div id="city-weather-panel">
			<div class="city-name">
				{{ currentCity.name }}, {{ currentCity.sys.country }}
				<img ng-show="selectedCityId == homeCity" src="{{ owncloudAppImgPath }}/img/home-pick.png" />
				<img class="home-icon" ng-click="setHome(selectedCityId);" ng-show="selectedCityId != homeCity" src="{{ owncloudAppImgPath }}/img/home-nopick.png" />
			</div>
			<div class="city-current-temp">{{ currentCity.main.temp }}{{ metricRepresentation }}</div>
			<div class="city-current-pressure">Pressure: {{ currentCity.main.pressure }} hpa</div>
			<div class="city-current-humidity">Humidity: {{ currentCity.main.humidity}}%</div>
			<div class="city-current-weather">Cloudiness: {{ currentCity.weather[0].description }}</div>
			<div class="city-current-wind">Wind: {{ currentCity.wind.speed }} m/s - {{ currentCity.wind.desc }}</div>
			<div class="city-current-sunrise">Sunrise: {{ currentCity.sys.sunrise * 1000 | date:'HH:mm' }} Sunset: {{ currentCity.sys.sunset * 1000 | date:'HH:mm' }}</div>
		</div>
		<div id="city-forecast-panel">
			<table>
				<tr><th>Hour</th><th>Temperature</th><th>Weather</th><th>Pressure</th><th>Wind</th></tr>
				<tr ng-repeat="forecast in currentCity.forecast">
					<td>{{ forecast.hour * 1000 | date:'HH:mm'}}</td>
					<td>{{ forecast.temperature }}{{ metricRepresentation }}</td>
					<td>{{ forecast.weather }}</td>
					<td>{{ forecast.pressure }}</td>
					<td>{{ forecast.wind.speed }} m/s - {{ forecast.wind.desc }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
