<?php

declare(strict_types=1);
/**
 * This file is part of OpenSwoole.
 * @link     https://openswoole.com
 * @contact  hello@openswoole.com
 */
namespace OpenSwoole;

class Constant
{
    public const VERSION = '22.0.0-dev';

    public const VERSION_ID = 220000;

    public const MAJOR_VERSION = 22;

    public const MINOR_VERSION = 0;

    public const RELEASE_VERSION = 0;

    public const EXTRA_VERSION = 'dev';

    public const HAVE_COMPRESSION = 1;

    public const HAVE_ZLIB = 1;

    public const HAVE_BROTLI = 1;

    public const USE_HTTP2 = 1;

    public const USE_POSTGRES = 1;

    /**
     * socket type
     */
    public const SOCK_TCP = 1;

    public const SOCK_TCP6 = 3;

    public const SOCK_UDP = 2;

    public const SOCK_UDP6 = 4;

    public const SOCK_UNIX_DGRAM = 6;

    public const SOCK_UNIX_STREAM = 5;

    /**
     * simple socket type alias
     */
    public const TCP = 1;

    public const TCP6 = 3;

    public const UDP = 2;

    public const UDP6 = 4;

    public const UNIX_DGRAM = 6;

    public const UNIX_STREAM = 5;

    /**
     * simple api
     */
    public const SOCK_SYNC = 0;

    public const SOCK_ASYNC = 1;

    public const SYNC = 2048;

    public const ASYNC = 1024;

    public const KEEP = 4096;

    /**
     * use openssl
     */
    public const SSL = 512;

    /**
     * SSL methods
     */
    public const SSLv3_METHOD = 1;

    public const SSLv3_SERVER_METHOD = 2;

    public const SSLv3_CLIENT_METHOD = 3;

    public const TLSv1_METHOD = 6;

    public const TLSv1_SERVER_METHOD = 7;

    public const TLSv1_CLIENT_METHOD = 8;

    public const TLSv1_1_METHOD = 9;

    public const TLSv1_1_SERVER_METHOD = 10;

    public const TLSv1_1_CLIENT_METHOD = 11;

    public const TLSv1_2_METHOD = 12;

    public const TLSv1_2_SERVER_METHOD = 13;

    public const TLSv1_2_CLIENT_METHOD = 14;

    public const DTLS_SERVER_METHOD = 16;

    public const DTLS_CLIENT_METHOD = 15;

    public const SSLv23_METHOD = 0;

    public const SSLv23_SERVER_METHOD = 4;

    public const SSLv23_CLIENT_METHOD = 5;

    public const TLS_METHOD = 0;

    public const TLS_SERVER_METHOD = 4;

    public const TLS_CLIENT_METHOD = 5;

    public const SSL_TLSv1 = 8;

    public const SSL_TLSv1_1 = 16;

    public const SSL_TLSv1_2 = 32;

    public const SSL_TLSv1_3 = 64;

    public const SSL_DTLS = 128;

    public const SSL_SSLv2 = 2;

    /**
     * Register ERROR types
     */
    public const STRERROR_SYSTEM = 0;

    public const STRERROR_GAI = 1;

    public const STRERROR_DNS = 2;

    public const STRERROR_SWOOLE = 9;

    /**
     * Register ERROR constants
     */
    public const ERROR_MALLOC_FAIL = 501;

    public const ERROR_SYSTEM_CALL_FAIL = 502;

    public const ERROR_PHP_FATAL_ERROR = 503;

    public const ERROR_NAME_TOO_LONG = 504;

    public const ERROR_INVALID_PARAMS = 505;

    public const ERROR_QUEUE_FULL = 506;

    public const ERROR_OPERATION_NOT_SUPPORT = 507;

    public const ERROR_PROTOCOL_ERROR = 508;

    public const ERROR_WRONG_OPERATION = 509;

    public const ERROR_FILE_NOT_EXIST = 700;

    public const ERROR_FILE_TOO_LARGE = 701;

    public const ERROR_FILE_EMPTY = 702;

    public const ERROR_DNSLOOKUP_DUPLICATE_REQUEST = 710;

    public const ERROR_DNSLOOKUP_RESOLVE_FAILED = 711;

    public const ERROR_DNSLOOKUP_RESOLVE_TIMEOUT = 712;

    public const ERROR_DNSLOOKUP_UNSUPPORTED = 713;

    public const ERROR_DNSLOOKUP_NO_SERVER = 714;

    public const ERROR_BAD_IPV6_ADDRESS = 720;

    public const ERROR_UNREGISTERED_SIGNAL = 721;

    public const ERROR_EVENT_SOCKET_REMOVED = 800;

    public const ERROR_SESSION_CLOSED_BY_SERVER = 1001;

    public const ERROR_SESSION_CLOSED_BY_CLIENT = 1002;

    public const ERROR_SESSION_CLOSING = 1003;

    public const ERROR_SESSION_CLOSED = 1004;

    public const ERROR_SESSION_NOT_EXIST = 1005;

    public const ERROR_SESSION_INVALID_ID = 1006;

    public const ERROR_SESSION_DISCARD_TIMEOUT_DATA = 1007;

    public const ERROR_SESSION_DISCARD_DATA = 1008;

    public const ERROR_OUTPUT_BUFFER_OVERFLOW = 1009;

    public const ERROR_OUTPUT_SEND_YIELD = 1010;

    public const ERROR_SSL_NOT_READY = 1011;

    public const ERROR_SSL_CANNOT_USE_SENFILE = 1012;

    public const ERROR_SSL_EMPTY_PEER_CERTIFICATE = 1013;

    public const ERROR_SSL_VERIFY_FAILED = 1014;

    public const ERROR_SSL_BAD_CLIENT = 1015;

    public const ERROR_SSL_BAD_PROTOCOL = 1016;

    public const ERROR_SSL_RESET = 1017;

    public const ERROR_SSL_HANDSHAKE_FAILED = 1018;

    public const ERROR_PACKAGE_LENGTH_TOO_LARGE = 1201;

    public const ERROR_PACKAGE_LENGTH_NOT_FOUND = 1202;

    public const ERROR_DATA_LENGTH_TOO_LARGE = 1203;

    public const ERROR_TASK_PACKAGE_TOO_BIG = 2001;

    public const ERROR_TASK_DISPATCH_FAIL = 2002;

    public const ERROR_TASK_TIMEOUT = 2003;

    public const ERROR_HTTP2_STREAM_ID_TOO_BIG = 3001;

    public const ERROR_HTTP2_STREAM_NO_HEADER = 3002;

    public const ERROR_HTTP2_STREAM_NOT_FOUND = 3003;

    public const ERROR_HTTP2_STREAM_IGNORE = 3004;

    public const ERROR_AIO_BAD_REQUEST = 4001;

    public const ERROR_AIO_CANCELED = 4002;

    public const ERROR_AIO_TIMEOUT = 4003;

    public const ERROR_CLIENT_NO_CONNECTION = 5001;

    public const ERROR_SOCKET_CLOSED = 6001;

    public const ERROR_SOCKET_POLL_TIMEOUT = 6002;

    public const ERROR_SOCKS5_UNSUPPORT_VERSION = 7001;

    public const ERROR_SOCKS5_UNSUPPORT_METHOD = 7002;

    public const ERROR_SOCKS5_AUTH_FAILED = 7003;

    public const ERROR_SOCKS5_SERVER_ERROR = 7004;

    public const ERROR_SOCKS5_HANDSHAKE_FAILED = 7005;

    public const ERROR_HTTP_PROXY_HANDSHAKE_ERROR = 7101;

    public const ERROR_HTTP_INVALID_PROTOCOL = 7102;

    public const ERROR_HTTP_PROXY_HANDSHAKE_FAILED = 7103;

    public const ERROR_HTTP_PROXY_BAD_RESPONSE = 7104;

    public const ERROR_WEBSOCKET_BAD_CLIENT = 8501;

    public const ERROR_WEBSOCKET_BAD_OPCODE = 8502;

    public const ERROR_WEBSOCKET_UNCONNECTED = 8503;

    public const ERROR_WEBSOCKET_HANDSHAKE_FAILED = 8504;

    public const ERROR_WEBSOCKET_PACK_FAILED = 8505;

    public const ERROR_SERVER_MUST_CREATED_BEFORE_CLIENT = 9001;

    public const ERROR_SERVER_TOO_MANY_SOCKET = 9002;

    public const ERROR_SERVER_WORKER_TERMINATED = 9003;

    public const ERROR_SERVER_INVALID_LISTEN_PORT = 9004;

    public const ERROR_SERVER_TOO_MANY_LISTEN_PORT = 9005;

    public const ERROR_SERVER_PIPE_BUFFER_FULL = 9006;

    public const ERROR_SERVER_NO_IDLE_WORKER = 9007;

    public const ERROR_SERVER_ONLY_START_ONE = 9008;

    public const ERROR_SERVER_SEND_IN_MASTER = 9009;

    public const ERROR_SERVER_INVALID_REQUEST = 9010;

    public const ERROR_SERVER_CONNECT_FAIL = 9011;

    public const ERROR_SERVER_WORKER_EXIT_TIMEOUT = 9012;

    public const ERROR_SERVER_WORKER_ABNORMAL_PIPE_DATA = 9013;

    public const ERROR_SERVER_WORKER_UNPROCESSED_DATA = 9014;

    public const ERROR_CO_OUT_OF_COROUTINE = 10001;

    public const ERROR_CO_HAS_BEEN_BOUND = 10002;

    public const ERROR_CO_HAS_BEEN_DISCARDED = 10003;

    public const ERROR_CO_MUTEX_DOUBLE_UNLOCK = 10004;

    public const ERROR_CO_BLOCK_OBJECT_LOCKED = 10005;

    public const ERROR_CO_BLOCK_OBJECT_WAITING = 10006;

    public const ERROR_CO_YIELD_FAILED = 10007;

    public const ERROR_CO_GETCONTEXT_FAILED = 10008;

    public const ERROR_CO_SWAPCONTEXT_FAILED = 10009;

    public const ERROR_CO_MAKECONTEXT_FAILED = 10010;

    public const ERROR_CO_IOCPINIT_FAILED = 10011;

    public const ERROR_CO_PROTECT_STACK_FAILED = 10012;

    public const ERROR_CO_STD_THREAD_LINK_ERROR = 10013;

    public const ERROR_CO_DISABLED_MULTI_THREAD = 10014;

    public const ERROR_CO_CANNOT_CANCEL = 10015;

    public const ERROR_CO_NOT_EXISTS = 10016;

    public const ERROR_CO_CANCELED = 10017;

    public const ERROR_CO_TIMEDOUT = 10018;

    /**
     * trace log
     */
    public const TRACE_SERVER = 2;

    public const TRACE_CLIENT = 4;

    public const TRACE_BUFFER = 8;

    public const TRACE_CONN = 16;

    public const TRACE_EVENT = 32;

    public const TRACE_WORKER = 64;

    public const TRACE_MEMORY = 128;

    public const TRACE_REACTOR = 256;

    public const TRACE_PHP = 512;

    public const TRACE_HTTP = 1024;

    public const TRACE_HTTP2 = 2048;

    public const TRACE_EOF_PROTOCOL = 4096;

    public const TRACE_LENGTH_PROTOCOL = 8192;

    public const TRACE_CLOSE = 16384;

    public const TRACE_WEBSOCKET = 32768;

    public const TRACE_REDIS_CLIENT = 65536;

    public const TRACE_MYSQL_CLIENT = 131072;

    public const TRACE_HTTP_CLIENT = 262144;

    public const TRACE_AIO = 524288;

    public const TRACE_SSL = 1048576;

    public const TRACE_NORMAL = 2097152;

    public const TRACE_CHANNEL = 4194304;

    public const TRACE_TIMER = 8388608;

    public const TRACE_SOCKET = 16777216;

    public const TRACE_COROUTINE = 33554432;

    public const TRACE_CONTEXT = 67108864;

    public const TRACE_CO_HTTP_SERVER = 134217728;

    public const TRACE_TABLE = 268435456;

    public const TRACE_CO_CURL = 536870912;

    public const TRACE_CARES = 1073741824;

    public const TRACE_ALL = 9223372036854775807;

    /**
     * log level
     */
    public const LOG_DEBUG = 0;

    public const LOG_TRACE = 1;

    public const LOG_INFO = 2;

    public const LOG_NOTICE = 3;

    public const LOG_WARNING = 4;

    public const LOG_ERROR = 5;

    public const LOG_NONE = 6;

    public const LOG_ROTATION_SINGLE = 0;

    public const LOG_ROTATION_MONTHLY = 1;

    public const LOG_ROTATION_DAILY = 2;

    public const LOG_ROTATION_HOURLY = 3;

    public const LOG_ROTATION_EVERY_MINUTE = 4;

    public const IOV_MAX = 1024;
}
