<?php

namespace Binlog\Collector\Interfaces;

use Binlog\Collector\Dto\BinlogHistoryDto;
use Binlog\Collector\Dto\OnlyBinlogOffsetDto;
use Binlog\Collector\Dto\OnlyGtidOffsetRangeDto;

interface BinlogHistoryServiceInterface
{
    public function getChildSlaveId(int $index): int;

    public function getTemporarySlaveId(): int;

    public function transactional(callable $callable): bool;

    /**
     * @return OnlyGtidOffsetRangeDto[]
     */
    public function getChildGtidOffsetRanges(): array;

    public function getChildGtidOffsetRangeCount(): int;

    public function upsertChildGtidOffsetRange(
        int $child_index,
        OnlyBinlogOffsetDto $current_binlog_offset_dto,
        OnlyBinlogOffsetDto $end_gtid_offset_dto,
        string $current_binlog_offset_date
    ): int;

    public function insertChildGtidOffsetRange(OnlyGtidOffsetRangeDto $gtid_offset_range_dto): int;

    public function deleteAllChildGtidOffsetRanges(): int;

    public function deleteChildGtidOffsetRangeById(int $child_index): int;

    public function getMinCurrentBinlogPositionDate(): ?string;

    /**
     * insert Universal History Bulk
     *
     * @param BinlogHistoryDto[] $dtos
     *
     * @return int
     */
    public function insertHistoryBulk(array $dtos): int;

    public function getEmptyGtidBinlogCount(): int;

    public function getRecentEmptyGtidBinlogId(): int;

    public function getEmptyGtidBinlogDictsByLesserEqualId(int $id, int $limit): array;

    public function getEmptyGtidBinlogDictsByLesserId(int $id, int $limit): array;

    public function getEmptyGtidBinlogIdByLesserIdAndOffset(int $id, int $offset): int;

    public function updateBinlogGtid(int $id, string $gtid): void;

    public function getParentBinlogOffset(): OnlyBinlogOffsetDto;

    public function getParentBinlogDate(): ?string;

    public function upsertParentBinlogOffset(OnlyBinlogOffsetDto $binlog_offset_dto, string $binlog_date = null): int;
}
