<?php namespace Myth\Timer;

class Timer {

    /**
     * Holds the performance metrics we collect.
     *
     * @var array
     */
    protected $benchmarks = [];

    //--------------------------------------------------------------------

    /**
     * Starts a benchmark running.
     *
     * @param $key
     */
    public function start($key)
    {
        $key = strtolower($key);

        $this->benchmarks[$key] = [
            'start_time'    => microtime(true),
            'stop_time'     => 0.0,
            'avg_time'      => 0.0,
            'start_memory'  => memory_get_usage(true),
            'stop_memory'   => 0,
            'avg_memory'    => 0,
            'peak_memory'   => 0,
            'running'       => true
        ];
    }

    //--------------------------------------------------------------------

    /**
     * Stops a timer running and calculates the statistics.
     *
     * @param $key
     */
    public function stop($key)
    {
        $benchmark = $this->get($key);

        $benchmark['stop_time'] = microtime(true);
        $benchmark['avg_time']  = $benchmark['stop_time'] - $benchmark['start_time'];
        $benchmark['stop_memory']   = memory_get_usage(true);
        $benchmark['avg_memory']    = ( ($benchmark['stop_memory'] - $benchmark['start_memory']) / 1024 ) / 1024;
        $benchmark['peak_memory']   = memory_get_peak_usage(true) / 1024 / 1024;
        $benchmark['running']       = false;

        $this->benchmarks[$key] = $benchmark;
    }

    //--------------------------------------------------------------------

    /**
     * Returns an array of all metrics that have been captured.
     * 
     * @return array
     */
    public function all() 
    {
        return $this->benchmarks;
    }
    
    //--------------------------------------------------------------------

    /**
     * Returns a single benchmark item.
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $key = strtolower($key);

        if (! array_key_exists($key, $this->benchmarks))
        {
            throw new \RuntimeException('No Benchmark exists for: '. $key);
        }

        return $this->benchmarks[$key];
    }
    
    //--------------------------------------------------------------------

    /**
     * Returns a single benchmark formatted as a string.
     *
     * @param $key
     * @return string
     */
    public function output($key)
    {
        $key = strtolower($key);

        $benchmark = $this->get($key);

        return sprintf('[%s] %s seconds, %sMB memory (%sMB peak)',
                $key,
                number_format($benchmark['avg_time'], 4),
                number_format($benchmark['avg_memory'], 2),
                number_format($benchmark['peak_memory'], 2)
            );
    }
    
    //--------------------------------------------------------------------

}