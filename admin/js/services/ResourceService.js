angular.module('UmfragetoolLive')

  .factory("ResourceService", function ($http) {

    var get = function() {
      return $http
        .get("charts/resource")
        .then(function(data) {
          return data.data;
        });
    };

    var getResult = function() {
      return $http
        .get("chart/resource")
        .then(function(data) {
          return data.data;
        });
    };

    return {
      get: get,
      getResult: getResult
    };

  });