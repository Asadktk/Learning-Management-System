<?php

namespace Http\Controllers\Admin;

use Http\Models\Instructor;
use Http\Models\RequestModel;

class RequestController
{
    public function getRequest()
    {
        $requestModel = new RequestModel();

        $requests = $requestModel->getAllRequests();
        view('admin/request/show.view.php', ['requests' => $requests]);
    }


    public function approveRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['request_id'])) {
                echo "Request ID is required.";
                return;
            }

            $requestId = $_POST['request_id'];
            $requestModel = new RequestModel();

            // Get the request details
            $request = $requestModel->getRequestById($requestId);

            if ($request) {
                // Insert into instructor_course table
                $courseId = $request['course_id'];
                $instructorId = $request['instructor_id'];

                $success = $requestModel->assignCourseToInstructor($courseId, $instructorId);

                if ($success) {

                    $requestModel->deleteRequest($requestId);
                    redirect('/requests');
                } else {
                    echo "Failed to approve request.";
                }
            } else {
                echo "Request not found.";
            }
        }
    }


    public function rejectRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['request_id'])) {
                echo "Request ID is required.";
                return;
            }

            $requestId = $_POST['request_id'];
            $requestModel = new RequestModel();

            $success = $requestModel->updateRequestStatus($requestId, false);

            if ($success) {
                redirect('/requests');
            } else {
                echo "Failed to reject request.";
            }
        }
    }
}
