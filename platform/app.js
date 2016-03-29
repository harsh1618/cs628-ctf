var express = require('express');
var path = require('path');
var favicon = require('serve-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');
var basicAuth = require ('basic-auth');
var Sequelize = require('sequelize');
var Ddos = require('ddos');

var routes = require('./routes/index');
var users = require('./routes/users');
var config = require('./config.js');
var app = express();

// mysql db
app.locals.sequelize = new Sequelize('mysql://'+config.username+':'+config.password+'@172.27.20.7:3306/cs628');

var sequelize = app.locals.sequelize;
// model for flags
app.locals.flagModel = sequelize.define('flags', {
  username: { type: Sequelize.STRING, primaryKey: true},
  answers: {
    type: Sequelize.STRING,
    get: function () {
      return this.getDataValue('answers').split(',')
          .map(function (el) { return parseInt(el); });
    },
    set: function (val) {
      this.setDataValue('answers', val.join(','));
    }
  }
}, {
  timestamps: false
});

//model for users
app.locals.userModel = sequelize.define('users', {
  username: { type: Sequelize.STRING, primaryKey: true},
  password: Sequelize.STRING
}, {
  timestamps: false
});

sequelize.sync();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'jade');

// uncomment after placing your favicon in /public
//app.use(favicon(path.join(__dirname, 'public', 'favicon.ico')));
app.use(logger('dev'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));
var ddos = new Ddos({errormessage: 'WTF dude! Are you trying to DoS our sever?'});
app.use(ddos.express);

// basic auth
var auth = function (req, res, next) {
  function unauthorized(res) {
    res.set('WWW-Authenticate', 'Basic realm=Authorization Required');
    return res.sendStatus(401);
  }

  var user = basicAuth(req);

  if (!user || !user.name || !user.pass) {
    return unauthorized(res);
  }
  var userModel = req.app.locals.userModel;
  userModel.findOne({
    attributes: ['username'],
    where: {
      username: user.name,
      password: user.pass
    }
  }).then(function(data) {
    if(data === null) {
      return unauthorized(res);
    }
    else {
      return next();
    }
  });
};

app.use('/', auth, routes);
app.use('/users', auth, users);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  var err = new Error('Not Found');
  err.status = 404;
  next(err);
});

// error handlers

// development error handler
// will print stacktrace
if (app.get('env') === 'development') {
  app.use(function(err, req, res, next) {
    res.status(err.status || 500);
    res.render('error', {
      message: err.message,
      error: err
    });
  });
}

// production error handler
// no stacktraces leaked to user
app.use(function(err, req, res, next) {
  res.status(err.status || 500);
  res.render('error', {
    message: err.message,
    error: {}
  });
});


module.exports = app;
