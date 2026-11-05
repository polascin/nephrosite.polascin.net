"""One-shot encoder: lecture GIFs -> MP4 + WebP poster with correct frame delays."""
from __future__ import annotations

import json
import shutil
import subprocess
from pathlib import Path

from PIL import Image

NAMES = ["fosdl", "foazo", "ktx", "aem", "vmppd"]
DOCS = Path("docs")
WORK = Path("docs/_gif_encode_tmp")
FPS = 25
FRAME_MS = 1000 // FPS


def frame_delays(path: Path) -> list[int]:
    im = Image.open(path)
    delays: list[int] = []
    n = 0
    while True:
        try:
            delays.append(max(int(im.info.get("duration", 40)), 1))
            n += 1
            im.seek(n)
        except EOFError:
            break
    return delays


def main() -> None:
    if WORK.exists():
        shutil.rmtree(WORK)
    WORK.mkdir()

    try:
        for name in NAMES:
            gif = DOCS / f"{name}.gif"
            delays = frame_delays(gif)
            total_ms = sum(delays)

            seq = WORK / name
            seq.mkdir()
            im = Image.open(gif)
            out_i = 0
            for fi, delay in enumerate(delays):
                im.seek(fi)
                frame = im.convert("RGB")
                hold = max(delay, FRAME_MS)
                reps = max(1, round(hold / FRAME_MS))
                for _ in range(reps):
                    frame.save(seq / f"f{out_i:05d}.png")
                    out_i += 1

            mp4 = DOCS / f"{name}.mp4"
            subprocess.check_call(
                [
                    "ffmpeg",
                    "-hide_banner",
                    "-loglevel",
                    "error",
                    "-y",
                    "-framerate",
                    str(FPS),
                    "-i",
                    str(seq / "f%05d.png"),
                    "-c:v",
                    "libx264",
                    "-preset",
                    "slow",
                    "-crf",
                    "24",
                    "-pix_fmt",
                    "yuv420p",
                    "-profile:v",
                    "high",
                    "-level",
                    "4.0",
                    "-movflags",
                    "+faststart",
                    "-an",
                    str(mp4),
                ]
            )

            poster_idx = max(0, min(out_i - 1, out_i // 4))
            best_idx, best_score = poster_idx, -1
            for cand in range(max(0, poster_idx - 5), min(out_i, poster_idx + 20)):
                small = Image.open(seq / f"f{cand:05d}.png").resize((64, 36))
                pixels = getattr(small, "get_flattened_data", small.getdata)()
                score = len(set(pixels))
                if score > best_score:
                    best_score, best_idx = score, cand

            poster = DOCS / f"{name}-poster.webp"
            subprocess.check_call(
                [
                    "ffmpeg",
                    "-hide_banner",
                    "-loglevel",
                    "error",
                    "-y",
                    "-i",
                    str(seq / f"f{best_idx:05d}.png"),
                    "-c:v",
                    "libwebp",
                    "-quality",
                    "82",
                    str(poster),
                ]
            )

            probe = json.loads(
                subprocess.check_output(
                    [
                        "ffprobe",
                        "-v",
                        "error",
                        "-show_entries",
                        "format=duration,size",
                        "-of",
                        "json",
                        str(mp4),
                    ],
                    text=True,
                )
            )["format"]
            dur = float(probe["duration"])
            gif_mb = gif.stat().st_size / (1024 * 1024)
            mp4_mb = mp4.stat().st_size / (1024 * 1024)
            poster_kb = poster.stat().st_size / 1024
            print(
                f"{name}: gif_dur={total_ms/1000:.2f}s mp4_dur={dur:.2f}s "
                f"gif={gif_mb:.2f}MB mp4={mp4_mb:.2f}MB poster={poster_kb:.1f}KB "
                f"frames={out_i} poster_frame={best_idx} colors={best_score}"
            )
            if abs(dur - total_ms / 1000) > 0.5:
                raise SystemExit(f"duration mismatch for {name}")
    finally:
        if WORK.exists():
            shutil.rmtree(WORK)

    print("DONE")


if __name__ == "__main__":
    main()
