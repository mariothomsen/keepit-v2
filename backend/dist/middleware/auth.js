"use strict";

const jwt = require('jsonwebtoken');

module.exports = function (req, res, next) {
  const token = req.header('token');
  if (!token) return res.status(401).json({
    message: 'Auth Error'
  }); //console.log(token)

  try {
    const decoded = jwt.verify(token, 'randomString');
    req.user = decoded.user;
    next();
  } catch (e) {
    console.error(e);
    res.status(401).send({
      messsage: 'Invalid Token'
    });
  }
};