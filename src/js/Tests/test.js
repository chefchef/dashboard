var supertest = require("supertest");
var should = require("should");
var colors = require('colors');
var assert = require('assertthat');
var server = supertest.agent('http://192.168.33.10');

describe("api", function () {
    describe('Verify if api is running', function () {
        it("Api is up", function (done) {
            server
                .get("/api/widgets")
                .end(function (error, result) {
                    assert.that(result.status).is.equalTo(200);
                    done();
                });
        });
    });

    describe('Invalid route', function () {
        it("/api/aaaaaaa is a invalid route", function (done) {
            server
                .get("/api/aaaaaaa")
                .end(function (error, result) {
                    assert.that(result.status).is.equalTo(404);
                    done();
                });
        });
    });
});

describe("api routes", function () {
    describe('GET /api/widgets', function () {
        it("return all widgets", function (done) {
            server
                .get("/api/widgets")
                .expect("Content-type", /json/)
                .expect(200) // THis is HTTP response
                .end(function (error, result) {
                    assert.that(result.status).is.equalTo(200);
                    assert.that(result.error).is.equalTo(false);
                    assert.that(result.body).is.equalTo([{id: '1', name: 'clock'},
                        {id: '2', name: 'test'},
                        {id: '3', name: 'cpu'},
                        {id: '4', name: 'memory'},
                        {id: '5', name: 'text'},
                        {id: '6', name: 'other'},
                        {id: '7', name: 'weather'},
                        {id: '8', name: 'special'}]);
                    done();
                });
        });
    });
});

describe("nodejs", function() {
    describe("server is up", function() {
        it("node is executed", function(done) {
            supertest.agent('http://192.168.33.10:3001')
                .get("/")
                .expect("Content-type", /html/)
                .expect(200)
                .end(function(error, result) {
                    assert.that(result.status).is.equalTo(200);
                    assert.that(result.error).is.equalTo(false);
                    assert.that(result.text).is.equalTo('<h1>NodeJS is running</h1>');
                    done();
                });
        })
    });

    describe("redis", function() {
        it("redis is up for subscriber", function(done) {
            var redis = require('redis');
            var redisClient = redis.createClient(6379, '192.168.33.10');
            redisClient.ping(function() {
                done();
            });
        });
    })
})