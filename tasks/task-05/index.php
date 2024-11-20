<?php

class DocumentFlow
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getApprover($employeeId, $approverType)
    {
        $today = date('Y-m-d');

        $stmt = $this->pdo->prepare("
            SELECT deputy_id 
            FROM substitutions 
            WHERE employee_id = :employee_id 
            AND type = :type 
            AND :today BETWEEN start_date AND end_date
        ");

        $stmt->execute([
            ':employee_id' => $employeeId,
            ':type' => $approverType,
            ':today' => $today,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['deputy_id'];
        }

        return $employeeId;
    }

    public function approveDocument($documentId, $approverId, $approvalType)
    {
        $actualApproverId = $this->getApprover($approverId, $approvalType);

        $stmt = $this->pdo->prepare("
            INSERT INTO document_approvals 
            (document_id, approver_id, approval_type, approved_at, is_deputy) 
            VALUES 
            (:document_id, :approver_id, :approval_type, NOW(), :is_deputy)
        ");

        return $stmt->execute([
            ':document_id' => $documentId,
            ':approver_id' => $actualApproverId,
            ':approval_type' => $approvalType,
            ':is_deputy' => $actualApproverId != $approverId,
        ]);
    }
}

try {
    $documentFlow = new DocumentFlow($pdo);

    $documentFlow->approveDocument(
        documentId: 1,
        approverId: 5, // MANAGER ID
        approvalType: 'MANAGER_APPROVAL',
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
}
