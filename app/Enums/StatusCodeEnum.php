<?php

namespace App\Enums;

enum StatusCodeEnum : int
{
   case OK = 200;
   case CREATED = 201;
   case UPDATED = 202;
   case VALIDATION = 422;
   case NOT_FOUND = 404;
   case BAD_REQUEST = 400;
   case UNAUTHORIZED = 401;
   case SERVER_ERROR = 500;
   case FORBIDDEN = 403;
}