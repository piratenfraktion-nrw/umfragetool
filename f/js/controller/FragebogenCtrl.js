angular.module('Umfragetool')

  .controller("FragebogenCtrl", function ($scope, $http) {

        console.log("ctrl");

    $scope.submit_answer = function () {

      $scope.submitting = true;

      var submit_data = {
        survey_id: angular.element("#survey_id").val(),
        answers: $scope.answers
      };

      $http
        .post("", submit_data)
        .then(function (response_data) {

          var response = response_data.data;

          if(response.status == "success") {
            // TODO: alert mit modals ersetzen.
            alert("Antworten erfolgreich übermittelt.\nBisher wurden insgesamt " + response.sum_respondents + " Personen befragt.");
            location.reload();
          } else {
            alert("Fehler: " + response.message);
          }

          $scope.submitting = false;

        });

    };

  });