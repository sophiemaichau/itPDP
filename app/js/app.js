var app = angular.module("boulder", ['ngRoute']);

// Angiver hvor forskellige urls' fører hen
app.config(['$routeProvider',
  function($routeProvider) {

    $routeProvider.
      when('/index', {
        templateUrl: 'views/person.html',
        controller: 'appController'
      }).
      when('/play', {
        templateUrl: 'views/play.html',
        controller: 'appController'
      }).
      when('/opponent', {
        templateUrl: 'views/opponent.html',
        controller: 'appController'
      }).
      when('/level', {
        templateUrl: 'views/level.html',
        controller: 'appController'
      }).
      when('/goplay', {
        templateUrl: 'views/goplay.html',
        controller: 'appController'
      }).
      when('/stats', {
        templateUrl: 'views/stats.html',
        controller: 'appController'
      }).
      when('/ranking', {
        templateUrl: 'views/ranking.html',
        controller: 'appController'
      }).
      when('/settings', {
        templateUrl: 'views/settings.html',
        controller: 'appController'
      }).
      when('/login', {
        templateUrl: 'views/login.html',
        controller: 'appController'
      }).
      when('/createuser', {
        templateUrl: 'views/createuser.html',
        controller: 'appController'
      }).
      otherwise({
        redirectTo: '/index'
      });

}]);

// Tjekker om brugeren er logget ind - ellers redirects til login-siden
app.run(['$rootScope', '$location', function($rootScope, $location) {
  $rootScope.loggedUser = "";

  $rootScope.$on( "$routeChangeStart", function(event, next, current) {
    if ( $rootScope.loggedUser == "" || $rootScope.loggedUser == null ) {
      if ( next.templateUrl == "views/createuser.html" ){
        // hvis den går til #createuser, er redirekt ikke nødvendig
      }
      else if ( next.templateUrl == "views/login.html" ) {
        // hvis den går til #login, er redirekt ikke nødvendig
      } else {
        $location.path('/login');
      }
    }
  });
}]);

// Service til at gemme brugeren
app.service('gameService', function(){
  var game = [];

  // Gemmer spilet
  this.setGame = function(selectedGame){
    game = [{
      'game': selectedGame
    }];
  }

  this.setOpp = function(mePlayer, oppPlayer){
    game = [{
      'game': game[0].game,
      'player1': mePlayer,
      'player2': oppPlayer
    }];

  }

  this.startGame = function(level, no){
    game = [{
      'game': game[0].game,
      'player1': game[0].player1,
      'player2': game[0].player2,
      'level': level,
      'no': no
    }];

  }

  this.get = function () {
    return game;
  }

});

// Service til at gemme brugeren
app.service('userService', function(){
  var user = [];

  // Gemmer brugeren
  this.saveUser = function(id, name, email, picture){

    user = [{
      'id': id,
      'name': name,
      'email': email,
      'picture': picture
    }];

  }

  // Fjerner informationer om
  this.logOut = function(){
    user = [];
  }

  this.get = function () {
    return user;
  }

});

// Den generelle controller
app.controller('appController', function($scope, $http, $location, userService, gameService){


  $scope.isActive = function (viewLocation) {
     var active = (viewLocation === $location.path());
     return active;
   };

  $scope.user = userService.get();

  // Hvis brugeren er logget ind, gemmes informationer.
  if($scope.user[0] != null){
    $scope.id = $scope.user[0].id;
    $scope.name = $scope.user[0].name;
    $scope.email = $scope.user[0].email;
    $scope.picture = $scope.user[0].picture;
  }

});


// Controller til at styre login
app.controller('loginController', ['$rootScope', '$scope', '$location', '$http', 'userService', function($rootScope, $scope, $location, $http, userService){

    $scope.login = function(){
      if($scope.email != null && $scope.password != null){

        // Hvis både email og password er sat - kaldes der til serveren.
        $http({
          method: 'GET',
          url: 'resources/getUsers.php?email=' + $scope.email
          })
          .then(function successCallback(response) {
            // Hvis det lykkedes at connecte til databasen - så tjekker vi om der kommer noget tilbage
            if(response.data[0] != null){
              if(response.data[0].password == $scope.password ){
                // Når brugeren logger ind, gemmes informationerne om brugeren
                userService.saveUser(
                    response.data[0].id,
                    response.data[0].name,
                    response.data[0].email,
                    response.data[0].picture);

                // Der angives at der er logget ind og redirekter til /index
                $rootScope.loggedUser = true;
                $location.path( "/index" );
              }
              else{
                // Hvis ikke password'et er rigtigt
                $scope.loginFailed = "Ugyldigt login - prøv igen";
                $scope.password = "";
              }
            }
            else{
              // Hvis brugerens email ikke findes i databasen
              $scope.loginFailed = "Bruger ikke fundet";
              $scope.password = "";
            }
          // Ved fejl med at connecte til databasen
          }, function errorCallback(response) {
            $scope.loginFailed = "Fejl - kontakt admin";
            $scope.password = "";
          });
      }
      else{
        $scope.loginFailed = "Indtast både email og password";
      }

    }

    // Når man logger ud
    $scope.logout = function(){
      $rootScope.loggedUser = null;
      userService.logOut();
      $location.path( "/login" );
    }
}]);


// Controller til at lave bruger
app.controller('createUserController', ['$rootScope', '$scope', '$location', '$http', 'userService', function($rootScope, $scope, $location, $http, userService){

  $scope.createUser = function(){

    if($scope.password == $scope.password2){
      $http({
        method: "post",
        url: 'resources/createUser.php',
        data: {
          name: $scope.username,
          email: $scope.email,
          password: $scope.password
        },
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      })
      .then(function successCallback(response) {
          console.log(response);
          if(response.data == "Succes"){
            $http({
              method: 'GET',
              url: 'resources/getUsers.php?email=' + $scope.email
              })
              .then(function successCallback(response) {
                // Hvis det lykkedes at connecte til databasen - så tjekker vi om der kommer noget tilbage
                if(response.data[0] != null){
                    // Når brugeren logger ind, gemmes informationerne om brugeren
                    userService.saveUser(
                        response.data[0].id,
                        response.data[0].name,
                        response.data[0].email,
                        response.data[0].picture);

                    // Der angives at der er logget ind og redirekter til /index
                    $rootScope.loggedUser = true;
                    $location.path( "/index" );
                  }
                  else{
                    // Hvis ikke password'et er rigtigt
                    $scope.loginFailed = "Ugyldigt login - prøv igen";
                    $scope.password = "";
                  }

                }, function errorCallback(response) {

                });
          }
          else if(response.data == "Email_invalid"){
            $scope.createFailed = "Emailen er allerede i brug";
          }
        },
        function errorCallback(response) {
          $scope.createFailed = "Fejl - kontakt admin";
        }
      );
    }
    else{
      $scope.createFailed = "Kodeord er ikke ens";
    }
  }

}]);


app.controller('playController', function($scope, $http, gameService){

  console.log($scope.game);

  $scope.no = 3;
  $scope.selectedLevel = 'level1';

  // VÆLG SPIL
  $scope.selectGame = function(game){
    gameService.setGame(game);
  }

  $scope.selectOpp = function(oppPlayer){
    gameService.setOpp($scope.user[0].id, oppPlayer);
  }

  $scope.changeNo = function(change){
    if(($scope.no + parseInt(change)) > 0 && ($scope.no + parseInt(change)) < 6){
      $scope.no = $scope.no + parseInt(change);
    }
  }

  $scope.selectLevel = function(item){
    $scope.selectedLevel = item;
  }

  $scope.startGame = function(){
      gameService.startGame($scope.selectedLevel, $scope.no);

      $scope.readyGame = gameService.get();


      $http({
        method: "post",
        url: 'resources/startGame.php',
        data: {
          game: $scope.readyGame[0].game,
          level: $scope.readyGame[0].level,
          no: $scope.readyGame[0].no,
          player1: $scope.readyGame[0].player1,
          player2: $scope.readyGame[0].player2
        },
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      })
      .then(function successCallback(response) {
          console.log(response);

        },
        function errorCallback(response) {
          $scope.createFailed = "Fejl - kontakt admin";
        }
      );
  }


  // HENT ALLE SPILLERE
  $scope.opponents = [];
  $http({
    method: 'GET',
    url: 'resources/getUsers.php'
    })
    .then(function successCallback(response) {
      // Hvis det lykkedes at connecte til databasen - så tjekker vi om der kommer noget tilbage
      if(response.data[0] != null){
        for(var i = 0; i < response.data.length; i++){
          if(response.data[i].id == $scope.user[0].id){

            // Fjerner ens egen bruger fra array'et - sådan man ikke kan vælge sig selv
            response.data.splice(i, 1);
          }
        }

        $scope.opponents = response.data;
      }
      else{
        console.log("Ingen brugere");
      }
    // Ved fejl med at connecte til databasen
    }, function errorCallback(response) {
      $scope.loginFailed = "Fejl - kontakt admin";
      $scope.password = "";
    });


});


// Controller der styrer setting-siden
app.controller('settingsController', function(){


});

// Controller til at se om menu-punktet skal være "active"
app.controller('NavigationCtrl', ['$scope', '$location', function ($scope, $location) {
  $scope.isCurrentPath = function (path) {
    return $location.path() == path;
  };
}]);
