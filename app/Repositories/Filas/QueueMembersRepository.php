<?php

namespace App\Repositories\Filas;

use App\Models\Filas\QueueMembersModel;
use Exception;
use Illuminate\Support\Facades\DB;

class QueueMembersRepository
{
  protected $queuesMembersModel;

  public function __construct(QueueMembersModel $queuesMembersModel)
  {
    $this->queuesMembersModel = $queuesMembersModel;
  }

  public function get(?object $request)
  {
    $QueueMembersList = $this->queuesMembersModel->select();

    if (isset($request->membername)) {
      $QueueMembersList = $QueueMembersList->where('membername', $request->membername);
    }

    if (isset($request->queue_name)) {
      $QueueMembersList = $QueueMembersList->where('queue_name', $request->queue_name);
    }

    $QueueMembersList = $QueueMembersList->get()->toArray();

    return $QueueMembersList;
  }

  public function create(array $request)
  {
    try {
      $this->queuesMembersModel->insert($request);

      return ['success' => true];
    } catch (\Exception $erro) {

      return ['success' => false, 'exception' => $erro->getMessage()];
    }
  }

  /**
   * @author Daniel Lopes manfrini
   * @since 08/07/2024 - 125104-refactor
   * Realiza a exclusão com base na lógica:
   *
   * Para a exclusão do ramal, busca os queuemembers com base no membername.
   * Para a exclusão da fila, busca os queuemembers com base na queue_name.
   */
  public function delete(array $request)
  {
    try {

      if (!isset($request['queue_name']) && !isset($request['membername'])) {
        throw new \Exception('Não foi informado um nome da fila "queue_name" ou ramal "membername" para a exclusão.');
      } else {

        $QueueMembersList = $this->queuesMembersModel->select();

        if (isset($request['queue_name'])) {
          if (is_array($request['queue_name'])) {
            $QueueMembersList = $QueueMembersList->whereIn('queue_name', $request['queue_name']);
          } else {
            $QueueMembersList = $QueueMembersList->where('queue_name', $request['queue_name']);
          }
        }

        if (isset($request['membername'])) {

          if (is_array($request['membername'])) {
            $QueueMembersList = $QueueMembersList->whereIn('membername', $request['membername']);
          } else {
            $QueueMembersList = $QueueMembersList->where('membername', $request['membername']);
          }
        }

        $QueueMembersList->delete();

        return ['success' => true];
      }
    } catch (Exception $erro) {

      return ['success' => false, 'exception' => $erro->getMessage()];
    }
  }
}
