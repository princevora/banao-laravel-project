<?php

namespace App;

trait WithToastr
{
    /**
     * @var string $toastType
     */
    public string $toastType = "success";

    /**
     * @var string $toastMessage
     */
    public string $toastMessage = "No message provided";

    /**
     * @param string $type
     * @return $this
     */
    private function setType(string $type = "success")
    {
        // Set toast type
        $this->toastType = $type;

        // Return chain method
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    private function setMessage(string $message = "User Message")
    {
        // Set toast type
        $this->toastMessage = $message;

        // Return chain method
        return $this;
    }

    private function send()
    {
        return redirect()->back()->with('toastr', 
        [
            'type' => $this->toastType,
            'message' => $this->toastMessage
        ]);
    }
}
